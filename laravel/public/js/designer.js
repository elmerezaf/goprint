(function() {
'use strict';

var canvas;
var currentTool = 'text';
var zoom = 1;
var copiedObjectJson = null;
var currentSide = 'front';
var sideData = {
    front: null,
    back: null
};
var historyStack = [];
var historyIndex = -1;
var isRestoring = false;
var uploadedImages = [];
var isDirty = false;

document.addEventListener('DOMContentLoaded', function() {
    canvas = new fabric.Canvas('designCanvas', {
        width: 600,
        height: 360,
        backgroundColor: '#ffffff',
        preserveObjectStacking: true
    });

    canvas.on('object:modified', function() {
        if (!isRestoring) saveState();
        updateLayersList();
        isDirty = true;
        document.getElementById('designStatus').textContent = '未保存';
    });

    canvas.on('object:added', function(e) {
        if (!isRestoring && !e.e) saveState();
        updateLayersList();
        isDirty = true;
        document.getElementById('designStatus').textContent = '未保存';
    });

    canvas.on('object:removed', function() {
        if (!isRestoring) saveState();
        updateLayersList();
        isDirty = true;
        document.getElementById('designStatus').textContent = '未保存';
    });

    canvas.on('object:selected', function(e) {
        updateRightPanel(e.target);
        updateCoords(e.target);
        updateLayersList();
    });

    canvas.on('selection:cleared', function() {
        updateLayersList();
    });

    canvas.on('object:moving', function(e) {
        updateCoords(e.target);
    });

    canvas.on('object:scaling', function(e) {
        updateCoords(e.target);
    });

    window.addEventListener('beforeunload', function(e) {
        if (isDirty) {
            saveCurrentSideData();
            var data = {
                front: sideData.front,
                back: sideData.back,
                currentSide: currentSide
            };
            try { localStorage.setItem('goprint_design_emergency', JSON.stringify(data)); } catch(ex) {}
            e.preventDefault();
        }
    });

    initToolbar();
    initTools();
    initPanels();
    initCanvasControls();
    initEventListeners();
    initSideSwitcher();
    initBgTypeTabs();
    initGradientPresets();
    initQRCodeGenerator();
    initStyleButtons();
    initTemplateSearch();
    initSizePresets();
    initUploadPanel();

    var emergencyData = null;
    try {
        var savedJson = localStorage.getItem('goprint_design_emergency');
        if (savedJson) {
            emergencyData = JSON.parse(savedJson);
            localStorage.removeItem('goprint_design_emergency');
        }
    } catch(ex) {}

    if (emergencyData && emergencyData.front && emergencyData.front.objects && emergencyData.front.objects.length > 0) {
        if (confirm('检测到上次未保存的设计，是否恢复？')) {
            loadDesignData(emergencyData);
            currentSide = emergencyData.currentSide || 'front';
            document.getElementById('designStatus').textContent = '未保存';
            isDirty = true;
        }
    }

    if (!emergencyData || !isDirty) {
        addDefaultContent();
    }
    saveState();
    saveCurrentSideData();
    
    // Show text panel by default
    showPanel('textPanel');

    setInterval(autoSaveDesign, 30000);
});

function initSideSwitcher() {
    document.getElementById('btnFrontSide').addEventListener('click', function() {
        switchSide('front');
    });
    document.getElementById('btnBackSide').addEventListener('click', function() {
        switchSide('back');
    });
}

function switchSide(side) {
    if (side === currentSide) return;
    
    // Save current side
    saveCurrentSideData();
    
    // Update UI
    currentSide = side;
    document.querySelectorAll('.side-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(side === 'front' ? 'btnFrontSide' : 'btnBackSide').classList.add('active');
    
    // Clear canvas
    canvas.clear();
    canvas.setBackgroundColor('#ffffff', function() { canvas.renderAll(); });
    historyStack = [];
    historyIndex = -1;
    
    // Load saved data or initialize new
    if (sideData[side]) {
        canvas.loadFromJSON(sideData[side], function() {
            canvas.renderAll();
            updateLayersList();
        });
    } else {
        addDefaultContent();
    }
    saveState();
}

function saveCurrentSideData() {
    sideData[currentSide] = canvas.toJSON();
}

function loadDesignData(data) {
    isRestoring = true;
    canvas.clear();
    sideData.front = data.front || {};
    sideData.back = data.back || {};

    var sideToLoad = data.currentSide || 'front';
    var loadData = sideData[sideToLoad];
    currentSide = sideToLoad;

    if (loadData && loadData.objects && loadData.objects.length > 0) {
        canvas.loadFromJSON(loadData, function() {
            canvas.renderAll();
            isRestoring = false;
        });
    } else if (sideData.front && sideData.front.objects && sideData.front.objects.length > 0) {
        canvas.loadFromJSON(sideData.front, function() {
            canvas.renderAll();
            isRestoring = false;
        });
    } else {
        isRestoring = false;
    }
    historyStack = [];
    historyIndex = -1;
}

function initBgTypeTabs() {
    document.querySelectorAll('.bg-type-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.bg-type-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const type = this.dataset.type;
            
            // Clear existing background
            canvas.setBackgroundColor(null, function() {});
            canvas.setBackgroundImage(null, function() {});
            
            // Show the correct section
            document.querySelector('.bg-solid-section').style.display = type === 'solid' ? 'block' : 'none';
            document.querySelector('.bg-gradient-section').style.display = type === 'gradient' ? 'block' : 'none';
            document.querySelector('.bg-image-section').style.display = type === 'image' ? 'block' : 'none';
            
            // Set default white background for solid type
            if (type === 'solid') {
                canvas.setBackgroundColor('#ffffff', function() { canvas.renderAll(); });
            }
        });
    });
}

function initGradientPresets() {
    document.querySelectorAll('.gradient-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            applyGradientBackground(this.dataset.gradient);
        });
    });
}

function applyGradientBackground(gradientCss) {
    console.log('Applying gradient:', gradientCss);
    
    // First, clear any existing background
    canvas.setBackgroundColor(null, function() {});
    canvas.setBackgroundImage(null, function() {});

    const gradientEntry = (typeof GRADIENT_DATA !== 'undefined' ? GRADIENT_DATA : []).find(function(g) { return g.css === gradientCss; });
    let colors = gradientEntry ? gradientEntry.colors : null;
    if (!colors) {
        // Fallback colors if not in list
        colors = ['#667eea', '#764ba2'];
    }
    
    const width = canvas.width;
    const height = canvas.height;
    
    // Create temp canvas to render gradient
    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = width;
    tempCanvas.height = height;
    const tempCtx = tempCanvas.getContext('2d');
    
    // Create gradient
    const gradient = tempCtx.createLinearGradient(0, 0, width, height);
    gradient.addColorStop(0, colors[0]);
    gradient.addColorStop(1, colors[1]);
    
    tempCtx.fillStyle = gradient;
    tempCtx.fillRect(0, 0, width, height);
    
    // Convert to Fabric image
    fabric.Image.fromURL(tempCanvas.toDataURL(), function(img) {
        img.set({
            left: 0,
            top: 0,
            selectable: false,
            evented: false,
            opacity: 1
        });
        canvas.setBackgroundImage(img, function() {
            canvas.renderAll();
        }, {
            scaleX: canvas.width / img.width,
            scaleY: canvas.height / img.height
        });
    });
}

function initQRCodeGenerator() {
    document.getElementById('btnGenerateQR').addEventListener('click', function() {
        generateQRCode();
    });
    
    // Tab switching
    document.getElementById('qr-url-tab').addEventListener('click', function() {
        switchQRTab('qr-url');
    });
    document.getElementById('qr-text-tab').addEventListener('click', function() {
        switchQRTab('qr-text');
    });
    document.getElementById('qr-card-tab').addEventListener('click', function() {
        switchQRTab('qr-card');
    });
}

function switchQRTab(tabId) {
    // Remove active class from all
    document.querySelectorAll('#qrTab .nav-link').forEach(function(el) {
        el.classList.remove('active');
    });
    // Hide all panes
    document.querySelectorAll('#qrTabContent .tab-pane').forEach(function(el) {
        el.classList.remove('show', 'active');
        el.style.display = 'none';
    });
    
    // Add active class to clicked tab
    document.getElementById(tabId + '-tab').classList.add('active');
    
    // Show the corresponding content
    var activePane = document.getElementById(tabId);
    activePane.style.display = 'block';
    activePane.classList.add('show', 'active');
}

function generateQRCode() {
    const activeTab = document.querySelector('#qrTab .nav-link.active');
    let content = '';
    
    if (activeTab.id === 'qr-url-tab') {
        content = document.getElementById('qrUrlInput').value;
    } else if (activeTab.id === 'qr-text-tab') {
        content = document.getElementById('qrTextInput').value;
    } else if (activeTab.id === 'qr-card-tab') {
        const name = document.getElementById('qrCardName').value;
        const phone = document.getElementById('qrCardPhone').value;
        const email = document.getElementById('qrCardEmail').value;
        content = 'BEGIN:VCARD\nVERSION:3.0\nN:' + name + '\nTEL;TYPE=CELL:' + phone + '\nEMAIL:' + email + '\nEND:VCARD';
    }
    
    if (!content) {
        alert('请输入内容');
        return;
    }
    
    const qrContainer = document.getElementById('qrcode');
    qrContainer.innerHTML = '';
    
    new QRCode(qrContainer, {
        text: content,
        width: 200,
        height: 200
    });
    
    setTimeout(function() {
        const qrImg = qrContainer.querySelector('img');
        if (qrImg) {
            fabric.Image.fromURL(qrImg.src, function(img) {
                const cx = canvas.width / 2;
                const cy = canvas.height / 2;
                img.set({
                    left: cx - 50,
                    top: cy - 50,
                    width: 100,
                    height: 100
                });
                canvas.add(img);
                canvas.setActiveObject(img);
                canvas.renderAll();
                qrContainer.innerHTML = '';
            });
        }
    }, 100);
}

function addDefaultContent() {
    const text = new fabric.Textbox('双击此处编辑文字', {
        left: 50,
        top: 150,
        width: 200,
        fontSize: 24,
        fontFamily: 'Microsoft YaHei',
        fill: '#333333',
        textAlign: 'left'
    });
    canvas.add(text);
    
    const companyText = new fabric.Textbox('GoPrint 网上印刷有限公司', {
        left: 280,
        top: 80,
        width: 220,
        fontSize: 18,
        fontFamily: 'Microsoft YaHei',
        fill: '#333333',
        fontWeight: 'bold'
    });
    canvas.add(companyText);
}

function saveState() {
    const json = JSON.stringify(canvas.toJSON(['id']));
    if (historyIndex < historyStack.length - 1) {
        historyStack = historyStack.slice(0, historyIndex + 1);
    }
    historyStack.push(json);
    if (historyStack.length > 100) historyStack.shift();
    historyIndex = historyStack.length - 1;
    document.getElementById('designStatus').textContent = '未保存';
}

function undo() {
    if (historyIndex > 0) {
        historyIndex--;
        isRestoring = true;
        canvas.loadFromJSON(JSON.parse(historyStack[historyIndex]), function() {
            canvas.renderAll();
            isRestoring = false;
            updateCoords(canvas.getActiveObject());
            updateLayersList();
        });
        document.getElementById('designStatus').textContent = '未保存';
    }
}

function redo() {
    if (historyIndex < historyStack.length - 1) {
        historyIndex++;
        isRestoring = true;
        canvas.loadFromJSON(JSON.parse(historyStack[historyIndex]), function() {
            canvas.renderAll();
            isRestoring = false;
            updateCoords(canvas.getActiveObject());
            updateLayersList();
        });
        document.getElementById('designStatus').textContent = '未保存';
    }
}

function initToolbar() {
    document.getElementById('btnUndo').addEventListener('click', undo);
    document.getElementById('btnRedo').addEventListener('click', redo);
    document.getElementById('btnCopy').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.clone(function(cloned) {
                copiedObjectJson = cloned.toJSON();
            });
        }
    });
    document.getElementById('btnCut').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.clone(function(cloned) {
                copiedObjectJson = cloned.toJSON();
            });
            canvas.remove(obj);
        }
    });
    document.getElementById('btnPaste').addEventListener('click', function() {
        if (copiedObjectJson) {
            fabric.util.enlivenObjects([copiedObjectJson], function(objects) {
                const obj = objects[0];
                obj.set({ left: (obj.left || 50) + 30, top: (obj.top || 50) + 30 });
                canvas.add(obj);
                canvas.setActiveObject(obj);
                canvas.renderAll();
            });
        }
    });
    document.getElementById('btnDelete').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) {
            canvas.remove(obj);
            canvas.discardActiveObject().renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });
    document.getElementById('btnBringToFront').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.bringToFront();
            canvas.renderAll();
        }
    });
    document.getElementById('btnSendToBack').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.sendToBack();
            canvas.renderAll();
        }
    });
    document.getElementById('btnGroup').addEventListener('click', function() {
        const objs = canvas.getActiveObjects();
        if (objs.length > 1) {
            const group = new fabric.Group(objs, { id: 'group' });
            canvas.discardActiveObject();
            objs.forEach(function(o) { canvas.remove(o); });
            canvas.add(group);
            canvas.setActiveObject(group);
            canvas.renderAll();
        }
    });
    document.getElementById('btnUngroup').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'group') {
            const items = obj._objects;
            obj.destroy();
            items.forEach(function(item) { canvas.add(item); });
            canvas.renderAll();
        }
    });
    document.getElementById('btnFlipH').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) { obj.set('flipX', !obj.flipX); canvas.renderAll(); }
    });
    document.getElementById('btnFlipV').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) { obj.set('flipY', !obj.flipY); canvas.renderAll(); }
    });
    document.getElementById('btnRotateL').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) { obj.set('angle', (obj.angle || 0) - 15); canvas.renderAll(); }
    });
    document.getElementById('btnRotateR').addEventListener('click', function() {
        const obj = canvas.getActiveObject();
        if (obj) { obj.set('angle', (obj.angle || 0) + 15); canvas.renderAll(); }
    });
    document.getElementById('btnAlignLeft').addEventListener('click', function() { alignObject('left'); });
    document.getElementById('btnAlignCenter').addEventListener('click', function() { alignObject('center'); });
    document.getElementById('btnAlignRight').addEventListener('click', function() { alignObject('right'); });
    document.getElementById('btnAlignTop').addEventListener('click', function() { alignObject('top'); });
    document.getElementById('btnAlignMiddle').addEventListener('click', function() { alignObject('middle'); });
    document.getElementById('btnAlignBottom').addEventListener('click', function() { alignObject('bottom'); });
    document.getElementById('btnDistributeH').addEventListener('click', function() { distributeObjects('horizontal'); });
    document.getElementById('btnDistributeV').addEventListener('click', function() { distributeObjects('vertical'); });
}

function initTools() {
    const toolButtons = document.querySelectorAll('.tool-btn');
    toolButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            toolButtons.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            currentTool = this.dataset.tool;
            showPanel(currentTool + 'Panel');
        });
    });
}

function initPanels() {
    document.getElementById('btnAddText').addEventListener('click', addNewText);
    document.getElementById('fontSize').addEventListener('input', function() {
        document.getElementById('fontSizeValue').textContent = this.value;
        updateSelectedText();
    });
    document.getElementById('fontFamily').addEventListener('change', updateSelectedText);
    document.getElementById('textColor').addEventListener('change', updateSelectedText);
    
    document.querySelectorAll('.color-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const color = this.dataset.color;
            // Determine if we're in background panel
            const bgPanelVisible = document.getElementById('backgroundPanel').style.display !== 'none';
            const bgSolidSectionVisible = document.querySelector('.bg-solid-section').style.display !== 'none';
            
            if (bgPanelVisible && bgSolidSectionVisible) {
                // We're setting background color - clear any gradient
                canvas.setBackgroundImage(null, function() {});
                const bgColorInput = document.getElementById('bgColor');
                if (bgColorInput) {
                    bgColorInput.value = color;
                    canvas.setBackgroundColor(color, function() { canvas.renderAll(); });
                }
            } else if (bgPanelVisible) {
                // We're in background panel but not solid - do nothing
            } else {
                const textColorInput = document.getElementById('textColor');
                if (textColorInput) {
                    textColorInput.value = color;
                    updateSelectedText();
                }
            }
        });
    });
    
    // Also update the bgColor input change listener to clear gradients
    document.getElementById('bgColor').addEventListener('change', function() {
        canvas.setBackgroundImage(null, function() {});
        canvas.setBackgroundColor(this.value, function() { canvas.renderAll(); });
    });
    
    document.querySelectorAll('.align-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.align-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            const obj = canvas.getActiveObject();
            if (obj && (obj.type === 'textbox' || obj.type === 'i-text')) {
                obj.set('textAlign', this.dataset.align);
                canvas.renderAll();
            }
        });
    });
    
    document.querySelectorAll('.shape-btn').forEach(function(btn) {
        btn.addEventListener('click', function() { addShape(this.dataset.shape); });
    });
    
    document.getElementById('shapeFill').addEventListener('change', updateSelectedShape);
    document.getElementById('shapeStroke').addEventListener('change', updateSelectedShape);
    document.getElementById('shapeStrokeWidth').addEventListener('input', updateSelectedShape);
    
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        if (e.target.files[0]) uploadImage(e.target.files[0]);
    });
    
    document.getElementById('imageOpacity').addEventListener('input', function() {
        const obj = canvas.getActiveObject();
        if (obj && obj.type === 'image') {
            obj.set('opacity', this.value / 100);
            canvas.renderAll();
        }
    });
    
    document.getElementById('bgImageUpload').addEventListener('change', function(e) {
        if (e.target.files[0]) setBackgroundImage(e.target.files[0]);
    });
    
    document.querySelectorAll('.template-item').forEach(function(item) {
        item.addEventListener('click', function() {
            let svgContent = '';
            if (this.dataset.svg) {
                try {
                    const binary = atob(this.dataset.svg);
                    const bytes = new Uint8Array(binary.length);
                    for (let i = 0; i < binary.length; i++) {
                        bytes[i] = binary.charCodeAt(i);
                    }
                    svgContent = new TextDecoder('utf-8').decode(bytes);
                } catch(e) { console.warn('SVG decode error:', e); }
            }
            loadTemplate(
                svgContent,
                parseFloat(this.dataset.width),
                parseFloat(this.dataset.height),
                this.dataset.bg
            );
        });
    });
    
    document.getElementById('objOpacity').addEventListener('input', function() {
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.set('opacity', this.value / 100);
            canvas.renderAll();
        }
    });
    
    document.getElementById('btnLock').addEventListener('click', toggleLock);
}

function initCanvasControls() {
    document.getElementById('zoomIn').addEventListener('click', function() {
        zoom = Math.min(3, zoom + 0.1);
        updateZoom();
    });
    document.getElementById('zoomOut').addEventListener('click', function() {
        zoom = Math.max(0.3, zoom - 0.1);
        updateZoom();
    });
    document.getElementById('zoomReset').addEventListener('click', function() {
        zoom = 1;
        updateZoom();
    });
    
    document.getElementById('zoomPreset').addEventListener('change', function() {
        zoom = parseFloat(this.value);
        updateZoom();
    });
}

function initEventListeners() {
    canvas.on('mouse:move', function(e) {
        if (e.pointer) {
            document.getElementById('coordDisplay').textContent =
                'X: ' + Math.round(e.pointer.x) + ', Y: ' + Math.round(e.pointer.y);
        }
    });
    document.getElementById('btnPreview').addEventListener('click', previewDesign);
    document.getElementById('btnSave').addEventListener('click', function(e) {
        var menu = document.getElementById('saveDropdownMenu');
        if (menu.style.display === 'none') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
        e.stopPropagation();
    });

    document.addEventListener('click', function() {
        var menu = document.getElementById('saveDropdownMenu');
        if (menu) menu.style.display = 'none';
    });
    document.getElementById('btnOrder').addEventListener('click', orderDesign);
}

function updateZoom() {
    canvas.setZoom(zoom);
    document.getElementById('zoomLevel').textContent = Math.round(zoom * 100) + '%';
}

function showPanel(panelId) {
    document.querySelectorAll('.panel-section').forEach(function(p) { p.style.display = 'none'; });
    const el = document.getElementById(panelId);
    if (el) el.style.display = 'block';
}

function addNewText() {
    const cx = canvas.width / 2, cy = canvas.height / 2;
    const text = new fabric.Textbox('点击编辑文字', {
        left: cx - 80,
        top: cy - 20,
        width: 160,
        fontSize: parseInt(document.getElementById('fontSize').value) || 24,
        fontFamily: document.getElementById('fontFamily').value || 'Microsoft YaHei',
        fill: document.getElementById('textColor').value || '#333333',
        textAlign: 'left'
    });
    canvas.add(text);
    canvas.setActiveObject(text);
    canvas.renderAll();
}

function addShape(type) {
    const cx = canvas.width / 2, cy = canvas.height / 2;
    const fill = document.getElementById('shapeFill').value;
    const stroke = document.getElementById('shapeStroke').value;
    const sw = parseInt(document.getElementById('shapeStrokeWidth').value) || 1;
    let shape;
    switch(type) {
        case 'rect':
            shape = new fabric.Rect({ left: cx - 50, top: cy - 30, width: 100, height: 60, fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'circle':
            shape = new fabric.Circle({ left: cx - 40, top: cy - 40, radius: 40, fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'triangle':
            shape = new fabric.Triangle({ left: cx - 50, top: cy - 40, width: 100, height: 80, fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'line':
            shape = new fabric.Line([cx - 50, cy, cx + 50, cy], { stroke: stroke, strokeWidth: sw });
            break;
        case 'ellipse':
            shape = new fabric.Ellipse({ left: cx - 50, top: cy - 30, rx: 50, ry: 30, fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'diamond':
            shape = new fabric.Polygon([
                { x: cx, y: cy - 40 },
                { x: cx + 40, y: cy },
                { x: cx, y: cy + 40 },
                { x: cx - 40, y: cy }
            ], { fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'star':
            shape = new fabric.Polygon([
                { x: cx, y: cy - 40 },
                { x: cx + 12, y: cy - 15 },
                { x: cx + 45, y: cy - 15 },
                { x: cx + 18, y: cy + 5 },
                { x: cx + 28, y: cy + 35 },
                { x: cx, y: cy + 20 },
                { x: cx - 28, y: cy + 35 },
                { x: cx - 18, y: cy + 5 },
                { x: cx - 45, y: cy - 15 },
                { x: cx - 12, y: cy - 15 }
            ], { fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'heart':
            shape = new fabric.Path('M ' + cx + ' ' + (cy - 30) + ' C ' + (cx - 40) + ' ' + (cy - 50) + ', ' + (cx - 60) + ' ' + (cy - 20) + ', ' + cx + ' ' + (cy + 15) + ' C ' + (cx + 60) + ' ' + (cy - 20) + ', ' + (cx + 40) + ' ' + (cy - 50) + ', ' + cx + ' ' + (cy - 30), { fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'hexagon':
            const points = [];
            for (let i = 0; i < 6; i++) {
                points.push({
                    x: cx + 40 * Math.cos(i * Math.PI / 3),
                    y: cy + 40 * Math.sin(i * Math.PI / 3)
                });
            }
            shape = new fabric.Polygon(points, { fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'roundedRect':
            shape = new fabric.Rect({ left: cx - 50, top: cy - 30, width: 100, height: 60, rx: 10, ry: 10, fill: fill, stroke: stroke, strokeWidth: sw });
            break;
        case 'dashedLine':
            shape = new fabric.Line([cx - 50, cy, cx + 50, cy], { stroke: stroke, strokeWidth: sw, strokeDashArray: [5, 5] });
            break;
        case 'dotLine':
            shape = new fabric.Line([cx - 50, cy, cx + 50, cy], { stroke: stroke, strokeWidth: sw, strokeDashArray: [2, 8] });
            break;
    }
    if (shape) {
        canvas.add(shape);
        canvas.setActiveObject(shape);
        canvas.renderAll();
    }
}

function uploadImage(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        fabric.Image.fromURL(e.target.result, function(img) {
            if (img.width > 200) img.scaleToWidth(200);
            if (img.height > 200) img.scaleToHeight(200);
            img.set({
                left: (canvas.width - img.getScaledWidth()) / 2,
                top: (canvas.height - img.getScaledHeight()) / 2
            });
            canvas.add(img);
            canvas.setActiveObject(img);
            canvas.renderAll();
        });
    };
    reader.readAsDataURL(file);
}

function setBackgroundImage(file) {
    var reader = new FileReader();
    reader.onload = function(e) {
        fabric.Image.fromURL(e.target.result, function(img) {
            img.set({
                left: 0,
                top: 0,
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height,
                selectable: true,
                evented: true,
                excludeFromExport: false
            });
            canvas.add(img);
            canvas.sendToBack(img);
            canvas.setActiveObject(img);
            canvas.renderAll();
            isDirty = true;
        });
    };
    reader.readAsDataURL(file);
}

function convertToTextbox(textObj, scaleX, scaleY) {
    return new fabric.Textbox(textObj.text || '', {
        left: (textObj.left || 0) * scaleX,
        top: (textObj.top || 0) * scaleY,
        width: Math.max((textObj.width || 100) * scaleX, 60),
        fontSize: (textObj.fontSize || 18) * scaleX,
        fontFamily: textObj.fontFamily || 'Microsoft YaHei',
        fill: textObj.fill || '#333333',
        fontWeight: textObj.fontWeight || 'normal',
        fontStyle: textObj.fontStyle || 'normal',
        textAlign: textObj.textAlign || 'left',
        underline: textObj.underline || false,
        linethrough: textObj.linethrough || false,
        lineHeight: textObj.lineHeight || 1.16,
        charSpacing: textObj.charSpacing || 0,
        selectable: true,
        evented: true,
        hasControls: true,
        hasBorders: true
    });
}

function loadTemplate(svgContent, width, height, bgColor) {
    if (isDirty) {
        if (!confirm('切换模板将清除当前设计，是否继续？')) return;
    }
    canvas.clear();
    canvas.setBackgroundColor(bgColor || '#ffffff', function() { canvas.renderAll(); });
    const mmToPx = 3.78;
    const targetWidth = Math.round(width * mmToPx);
    const targetHeight = Math.round(height * mmToPx);
    
    canvas.setDimensions({ width: targetWidth, height: targetHeight });
    
    const canvasArea = document.querySelector('.canvas-area');
    const availableWidth = canvasArea.clientWidth - 30;
    const availableHeight = canvasArea.clientHeight - 80;
    
    let displayScale = 1;
    if (targetWidth > availableWidth || targetHeight > availableHeight) {
        displayScale = Math.min(availableWidth / targetWidth, availableHeight / targetHeight);
    }
    
    zoom = displayScale;
    updateZoom();
    
    document.getElementById('canvasSize').textContent = width + 'mm x ' + height + 'mm';
    document.getElementById('designStatus').textContent = '未保存';
    isDirty = false;
    historyStack = [];
    historyIndex = -1;
    
    if (svgContent) {
        fabric.loadSVGFromString(svgContent, function(objects, options) {
            if (!objects || objects.length === 0) {
                addDefaultContent();
                canvas.renderAll();
                return;
            }
            
            const svgWidth = parseFloat(options.width) || width;
            const svgHeight = parseFloat(options.height) || height;
            
            const scaleX = targetWidth / svgWidth;
            const scaleY = targetHeight / svgHeight;
            
            objects.forEach(function(obj) {
                if (obj.type === 'group') {
                    obj._objects.forEach(function(subObj) {
                        if (subObj.type === 'text') {
                            canvas.add(convertToTextbox(subObj, scaleX, scaleY));
                        } else if (subObj.type === 'textbox') {
                            subObj.set({
                                left: (subObj.left || 0) * scaleX,
                                top: (subObj.top || 0) * scaleY,
                                fontSize: (subObj.fontSize || 12) * scaleX,
                                width: (subObj.width || 100) * scaleX,
                                fontFamily: subObj.fontFamily || 'Microsoft YaHei',
                                selectable: true,
                                evented: true,
                                hasControls: true,
                                hasBorders: true
                            });
                            canvas.add(subObj);
                        } else {
                            subObj.set({
                                left: (subObj.left || 0) * scaleX,
                                top: (subObj.top || 0) * scaleY,
                                scaleX: (subObj.scaleX || 1),
                                scaleY: (subObj.scaleY || 1),
                                selectable: true,
                                evented: true,
                                hasControls: true,
                                hasBorders: true
                            });
                            canvas.add(subObj);
                        }
                    });
                } else if (obj.type === 'text') {
                    canvas.add(convertToTextbox(obj, scaleX, scaleY));
                } else if (obj.type === 'textbox') {
                    obj.set({
                        left: (obj.left || 0) * scaleX,
                        top: (obj.top || 0) * scaleY,
                        fontSize: (obj.fontSize || 12) * scaleX,
                        width: (obj.width || 100) * scaleX,
                        fontFamily: obj.fontFamily || 'Microsoft YaHei',
                        selectable: true,
                        evented: true,
                        hasControls: true,
                        hasBorders: true
                    });
                    canvas.add(obj);
                } else {
                    obj.set({
                        left: (obj.left || 0) * scaleX,
                        top: (obj.top || 0) * scaleY,
                        scaleX: (obj.scaleX || 1),
                        scaleY: (obj.scaleY || 1),
                        selectable: true,
                        evented: true,
                        hasControls: true,
                        hasBorders: true
                    });
                    canvas.add(obj);
                }
            });
            canvas.renderAll();
            saveState();
        });
    } else {
        addDefaultContent();
        canvas.renderAll();
    }
}

function updateLayersList() {
    const list = document.getElementById('layersList');
    const placeholder = document.getElementById('layersPlaceholder');
    const objects = canvas.getObjects();
    list.querySelectorAll('.layer-item').forEach(function(el) { el.remove(); });
    if (objects.length === 0) {
        if (placeholder) placeholder.style.display = 'block';
        return;
    }
    if (placeholder) placeholder.style.display = 'none';
    for (let i = objects.length - 1; i >= 0; i--) {
        const obj = objects[i];
        const item = document.createElement('div');
        item.className = 'layer-item';
        if (obj === canvas.getActiveObject()) item.classList.add('active');

        const eye = document.createElement('i');
        eye.className = obj.visible === false ? 'fas fa-eye-slash' : 'fas fa-eye';
        eye.style.cssText = 'margin-right:6px;cursor:pointer;font-size:12px;width:16px;text-align:center;';
        eye.title = obj.visible === false ? '显示' : '隐藏';
        eye.addEventListener('click', function(e) {
            e.stopPropagation();
            obj.visible = !obj.visible;
            eye.className = obj.visible === false ? 'fas fa-eye-slash' : 'fas fa-eye';
            eye.title = obj.visible === false ? '显示' : '隐藏';
            canvas.renderAll();
            isDirty = true;
        });
        item.appendChild(eye);

        const icon = document.createElement('i');
        const typeName = obj.type || 'unknown';
        let displayName = typeName;
        if (typeName === 'textbox' || typeName === 'i-text' || typeName === 'text') {
            icon.className = 'fas fa-font';
            displayName = '文字';
        } else if (typeName === 'image') {
            icon.className = 'fas fa-image';
            displayName = '图片';
        } else if (typeName === 'group') {
            icon.className = 'fas fa-object-group';
            displayName = '组合';
        } else {
            icon.className = 'fas fa-shape';
            displayName = '形状';
        }
        item.appendChild(icon);

        const name = document.createElement('span');
        name.textContent = displayName;
        name.style.marginLeft = '4px';
        item.appendChild(name);
        const lockIcon = document.createElement('i');
        lockIcon.className = obj.evented === false ? 'fas fa-lock' : 'fas fa-lock-open';
        lockIcon.style.marginLeft = 'auto';
        lockIcon.style.fontSize = '11px';
        lockIcon.style.opacity = '0.5';
        item.appendChild(lockIcon);
        item.addEventListener('click', (function(objRef) {
            return function() {
                canvas.setActiveObject(objRef);
                canvas.renderAll();
                updateLayersList();
                updateRightPanel(objRef);
                updateCoords(objRef);
            };
        })(obj));
        list.appendChild(item);
    }
}

function alignObject(direction) {
    const obj = canvas.getActiveObject();
    if (!obj) return;
    const bound = obj.getBoundingRect();
    switch (direction) {
        case 'left': obj.set('left', 0); break;
        case 'center': obj.set('left', (canvas.width - bound.width) / 2); break;
        case 'right': obj.set('left', canvas.width - bound.width); break;
        case 'top': obj.set('top', 0); break;
        case 'middle': obj.set('top', (canvas.height - bound.height) / 2); break;
        case 'bottom': obj.set('top', canvas.height - bound.height); break;
    }
    obj.setCoords();
    canvas.renderAll();
    saveState();
}

function distributeObjects(direction) {
    const activeObjs = canvas.getActiveObjects();
    if (activeObjs.length < 3) return;
    if (direction === 'horizontal') {
        activeObjs.sort(function(a, b) { return a.left - b.left; });
        const first = activeObjs[0].left;
        const last = activeObjs[activeObjs.length - 1].left;
        const totalWidth = last - first;
        const gap = totalWidth / (activeObjs.length - 1);
        activeObjs.forEach(function(obj, i) {
            if (i > 0 && i < activeObjs.length - 1) {
                obj.set('left', first + gap * i);
                obj.setCoords();
            }
        });
    } else {
        activeObjs.sort(function(a, b) { return a.top - b.top; });
        const first = activeObjs[0].top;
        const last = activeObjs[activeObjs.length - 1].top;
        const totalHeight = last - first;
        const gap = totalHeight / (activeObjs.length - 1);
        activeObjs.forEach(function(obj, i) {
            if (i > 0 && i < activeObjs.length - 1) {
                obj.set('top', first + gap * i);
                obj.setCoords();
            }
        });
    }
    canvas.renderAll();
    saveState();
}

function toggleLock() {
    const obj = canvas.getActiveObject();
    if (!obj) return;
    const isLocked = obj.evented === false;
    obj.set({
        evented: isLocked ? true : false,
        selectable: isLocked ? true : false,
        hasControls: isLocked ? true : false,
        hasBorders: isLocked ? true : false,
        lockMovementX: !isLocked,
        lockMovementY: !isLocked,
        lockRotation: !isLocked,
        lockScalingX: !isLocked,
        lockScalingY: !isLocked
    });
    canvas.renderAll();
    const btn = document.getElementById('btnLock');
    if (!isLocked) {
        btn.innerHTML = '<i class="fas fa-lock"></i> <span id="lockText">已锁定</span>';
        btn.classList.add('active');
    } else {
        btn.innerHTML = '<i class="fas fa-lock-open"></i> <span id="lockText">锁定</span>';
        btn.classList.remove('active');
    }
}

function autoSaveDesign() {
    if (!canvas) return;
    saveCurrentSideData();
    const data = {
        front: sideData.front,
        back: sideData.back,
        currentSide: currentSide
    };
    try {
        const json = JSON.stringify(data);
        const sizeKB = (json.length / 1024).toFixed(1);
        if (json.length > 4 * 1024 * 1024) {
            console.warn('设计数据过大 (' + sizeKB + 'KB)，可能无法完整保存');
        }
        localStorage.setItem('goprint_design_autosave', json);
        const statusEl = document.getElementById('designStatus');
        statusEl.textContent = '已自动保存';
        statusEl.style.color = '#2ecc71';
        setTimeout(function() {
            if (statusEl.textContent === '已自动保存') {
                statusEl.textContent = '未保存';
                statusEl.style.color = '#e74c3c';
            }
        }, 2000);
    } catch(e) {
        const statusEl = document.getElementById('designStatus');
        if (e.name === 'QuotaExceededError' || (e.code && e.code === 22)) {
            statusEl.textContent = '存储空间不足';
        } else {
            statusEl.textContent = '保存失败';
            console.error('Auto-save failed:', e);
        }
        statusEl.style.color = '#e74c3c';
    }
}

function updateSelectedText() {
    const obj = canvas.getActiveObject();
    if (obj && (obj.type === 'textbox' || obj.type === 'i-text' || obj.type === 'text')) {
        obj.set({
            fontSize: parseInt(document.getElementById('fontSize').value) || 24,
            fontFamily: document.getElementById('fontFamily').value || 'Microsoft YaHei',
            fill: document.getElementById('textColor').value || '#333333'
        });
        canvas.renderAll();
    }
}

function updateSelectedShape() {
    const obj = canvas.getActiveObject();
    if (obj && !['text', 'textbox', 'i-text', 'image'].includes(obj.type)) {
        obj.set({
            fill: document.getElementById('shapeFill').value,
            stroke: document.getElementById('shapeStroke').value,
            strokeWidth: parseInt(document.getElementById('shapeStrokeWidth').value) || 1
        });
        canvas.renderAll();
    }
}

function updateRightPanel(object) {
    if (!object) return;
    document.querySelectorAll('.panel-section').forEach(function(p) { p.style.display = 'none'; });
    if (['textbox', 'i-text', 'text'].includes(object.type)) {
        showPanel('textPanel');
        document.getElementById('fontSize').value = object.fontSize || 24;
        document.getElementById('fontSizeValue').textContent = object.fontSize || 24;
        document.getElementById('fontFamily').value = object.fontFamily || 'Microsoft YaHei';
        document.getElementById('textColor').value = object.fill || '#333333';
        updateSelectedTextStyle(object);
    } else if (object.type === 'image') {
        showPanel('imagePanel');
        document.getElementById('imageOpacity').value = Math.round((object.opacity || 1) * 100);
    } else {
        showPanel('shapePanel');
    }
    const objPanel = document.getElementById('objectPanel');
    if (objPanel) objPanel.style.display = 'block';
    const isLocked = object.evented === false;
    const btn = document.getElementById('btnLock');
    if (btn) {
        if (isLocked) {
            btn.innerHTML = '<i class="fas fa-lock"></i> <span id="lockText">已锁定</span>';
            btn.classList.add('active');
        } else {
            btn.innerHTML = '<i class="fas fa-lock-open"></i> <span id="lockText">锁定</span>';
            btn.classList.remove('active');
        }
    }
}

function updateCoords(object) {
    if (object) {
        document.getElementById('coordDisplay').textContent =
            'X: ' + Math.round(object.left || 0) + ', Y: ' + Math.round(object.top || 0) +
            ' | W: ' + Math.round((object.width || 0) * (object.scaleX || 1)) +
            ', H: ' + Math.round((object.height || 0) * (object.scaleY || 1));
    }
}

function previewDesign() {
    const dataURL = canvas.toDataURL({ format: 'png', quality: 1 });
    const w = window.open('', '_blank');
    if (!w) { alert('请允许弹出窗口以预览设计'); return; }
    const html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>设计预览 - GoPrint</title><style>body{margin:0;display:flex;justify-content:center;align-items:center;background:#f5f5f5;min-height:100vh;font-family:sans-serif;}</style></head><body><img src="' + dataURL + '" style="max-width:95%;max-height:95%;box-shadow:0 4px 20px rgba(0,0,0,0.2);border-radius:4px;"></body></html>';
    const blob = new Blob([html], { type: 'text/html' });
    w.location.href = URL.createObjectURL(blob);
}

function saveDesign(format) {
    format = format || 'svg';
    var data, blob, url, filename, mime;

    if (format === 'svg') {
        var svgFront = canvas.toSVG();
        var hasBack = sideData.back && sideData.back.objects && sideData.back.objects.length > 0;
        if (hasBack) {
            isRestoring = true;
            var savedFront = JSON.stringify(sideData.front);
            canvas.loadFromJSON(sideData.back, function() {
                var svgBack = canvas.toSVG();
                canvas.loadFromJSON(JSON.parse(savedFront), function() {
                    downloadSVG(svgFront, svgBack);
                    isRestoring = false;
                });
            });
        } else {
            downloadSVG(svgFront, null);
        }
        return;
    }

    saveCurrentSideData();
    data = {
        front: sideData.front,
        back: sideData.back
    };

    if (format === 'json') {
        mime = 'application/json';
        blob = new Blob([JSON.stringify(data, null, 2)], { type: mime });
        filename = 'goprint_design_' + Date.now() + '.json';
    } else if (format === 'png') {
        mime = 'image/png';
        blob = dataURLToBlob(canvas.toDataURL({ format: 'png', quality: 1 }));
        filename = 'goprint_design_front_' + Date.now() + '.png';
    }

    url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);

    document.getElementById('designStatus').textContent = '已保存';
    document.getElementById('designStatus').style.color = '#2ecc71';
    isDirty = false;
    setTimeout(function() {
        document.getElementById('designStatus').textContent = '未保存';
        document.getElementById('designStatus').style.color = '#e74c3c';
    }, 2000);
}

function downloadSVG(svgFront, svgBack) {
    var timestamp = Date.now();
    var cw = canvas.width;
    var ch = canvas.height;

    if (svgBack) {
        var totalH = ch * 2;
        var svgCombined = '<svg xmlns="http://www.w3.org/2000/svg" width="' + cw + 'px" height="' + totalH + 'px" viewBox="0 0 ' + cw + ' ' + totalH + '">' +
            '<rect width="' + cw + '" height="' + totalH + '" fill="white"/>' +
            '<g id="front">\n' + svgFront + '\n</g>' +
            '<g id="back" transform="translate(0, ' + ch + ')">\n' + svgBack + '\n</g>' +
            '</svg>';
        var blob = new Blob([svgCombined], { type: 'image/svg+xml', encoding: 'UTF-8' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'goprint_design_' + timestamp + '.svg';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);

        var jsonData = {
            front: sideData.front,
            back: sideData.back,
            exported_at: new Date().toISOString(),
            format: 'svg',
            canvas_width: cw,
            canvas_height: ch
        };
        var jsonBlob = new Blob([JSON.stringify(jsonData, null, 2)], { type: 'application/json' });
        var jsonUrl = URL.createObjectURL(jsonBlob);
        var jsonA = document.createElement('a');
        jsonA.href = jsonUrl;
        jsonA.download = 'goprint_design_' + timestamp + '.json';
        document.body.appendChild(jsonA);
        jsonA.click();
        document.body.removeChild(jsonA);
        URL.revokeObjectURL(jsonUrl);
    } else {
        var blob = new Blob([svgFront], { type: 'image/svg+xml', encoding: 'UTF-8' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'goprint_design_front_' + timestamp + '.svg';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    document.getElementById('designStatus').textContent = '已保存';
    document.getElementById('designStatus').style.color = '#2ecc71';
    isDirty = false;
    setTimeout(function() {
        document.getElementById('designStatus').textContent = '未保存';
        document.getElementById('designStatus').style.color = '#e74c3c';
    }, 2000);
}

function dataURLToBlob(dataURL) {
    var parts = dataURL.split(',');
    var mime = parts[0].match(/:(.*?);/)[1];
    var bstr = atob(parts[1]);
    var n = bstr.length;
    var u8arr = new Uint8Array(n);
    while (n--) { u8arr[n] = bstr.charCodeAt(n); }
    return new Blob([u8arr], { type: mime });
}

function orderDesign() {
    saveCurrentSideData();
    var designData = {
        front: sideData.front,
        back: sideData.back,
        saved_at: new Date().toISOString()
    };

    var token = 'design_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

    try {
        sessionStorage.setItem(token, JSON.stringify(designData));
    } catch(e) {
        try {
            localStorage.setItem(token, JSON.stringify(designData));
        } catch(e2) {
            alert('存储空间不足，请先保存设计文件');
            return;
        }
    }

    var svgFront = canvas.toSVG();
    var hasBack = sideData.back && sideData.back.objects && sideData.back.objects.length > 0;

    if (hasBack) {
        isRestoring = true;
        var savedFront = JSON.stringify(sideData.front);
        canvas.loadFromJSON(sideData.back, function() {
            var svgBack = canvas.toSVG();
            canvas.loadFromJSON(JSON.parse(savedFront), function() {
                orderWithSVG(svgFront, svgBack, token, designData);
                isRestoring = false;
            });
        });
    } else {
        orderWithSVG(svgFront, null, token, designData);
    }
}

function orderWithSVG(svgFront, svgBack, token, designData) {
    var productId = document.getElementById('productId').value;
    var redirectUrl = '/designer/order/' + encodeURIComponent(token);

    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfMeta ? csrfMeta.content : '';
    var formData = new FormData();
    formData.append('design_data', JSON.stringify(designData));
    formData.append('product_id', productId);
    formData.append('design_token', token);

    fetch('/designer/export', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        window.location.href = redirectUrl;
    })
    .catch(function(err) {
        console.warn('Server save failed, continuing with local storage:', err);
        window.location.href = redirectUrl;
    });
}

function initStyleButtons() {
    document.querySelectorAll('.style-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var obj = canvas.getActiveObject();
            if (!obj || !['textbox', 'i-text', 'text'].includes(obj.type)) return;

            var style = this.dataset.style;
            switch(style) {
                case 'bold':
                    var currentWeight = obj.fontWeight;
                    if (currentWeight === 'bold') {
                        obj.set('fontWeight', 'normal');
                        this.classList.remove('active');
                    } else {
                        obj.set('fontWeight', 'bold');
                        this.classList.add('active');
                    }
                    break;
                case 'italic':
                    var currentStyle = obj.fontStyle;
                    if (currentStyle === 'italic') {
                        obj.set('fontStyle', 'normal');
                        this.classList.remove('active');
                    } else {
                        obj.set('fontStyle', 'italic');
                        this.classList.add('active');
                    }
                    break;
                case 'underline':
                    if (obj.underline) {
                        obj.set('underline', false);
                        this.classList.remove('active');
                    } else {
                        obj.set('underline', true);
                        this.classList.add('active');
                    }
                    break;
            }
            canvas.renderAll();
            saveState();
        });
    });
}

function initTemplateSearch() {
    var searchInput = document.getElementById('templateSearch');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        var query = this.value.toLowerCase().trim();
        var categories = document.querySelectorAll('.template-category');
        var foundAny = false;

        categories.forEach(function(category) {
            var items = category.querySelectorAll('.template-item');
            var categoryVisible = false;

            items.forEach(function(item) {
                var name = (item.querySelector('.template-name') || item.querySelector('span')).textContent.toLowerCase();
                var categoryName = category.querySelector('.template-category-title').textContent.toLowerCase();

                if (!query || name.indexOf(query) !== -1 || categoryName.indexOf(query) !== -1) {
                    item.style.display = '';
                    categoryVisible = true;
                    foundAny = true;
                } else {
                    item.style.display = 'none';
                }
            });

            category.style.display = categoryVisible ? '' : 'none';
        });

        var emptyMsg = document.getElementById('templateEmpty');
        if (emptyMsg) {
            emptyMsg.style.display = foundAny ? 'none' : 'block';
        }
    });
}

function initSizePresets() {
    var presetButtons = document.querySelectorAll('.size-preset-btn');
    presetButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            presetButtons.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');

            var width = parseFloat(this.dataset.width);
            var height = parseFloat(this.dataset.height);
            var name = this.dataset.name;
            var bg = this.dataset.bg || '#ffffff';

            if (!width || !height) return;

            if (isDirty) {
                if (!confirm('切换尺寸将清除当前设计，是否继续？')) return;
            }

            var mmToPx = 3.78;
            var targetWidth = Math.round(width * mmToPx);
            var targetHeight = Math.round(height * mmToPx);

            canvas.clear();
            canvas.setBackgroundColor(bg, function() { canvas.renderAll(); });
            canvas.setDimensions({ width: targetWidth, height: targetHeight });

            var canvasArea = document.querySelector('.canvas-area');
            var availableWidth = canvasArea.clientWidth - 30;
            var availableHeight = canvasArea.clientHeight - 80;

            var displayScale = 1;
            if (targetWidth > availableWidth || targetHeight > availableHeight) {
                displayScale = Math.min(availableWidth / targetWidth, availableHeight / targetHeight);
            }

            zoom = displayScale;
            updateZoom();

            document.getElementById('canvasSize').textContent = width + 'mm x ' + height + 'mm';
            document.getElementById('designStatus').textContent = '未保存';
            isDirty = false;
            historyStack = [];
            historyIndex = -1;

            addDefaultContent();
            canvas.renderAll();
            saveState();
            saveCurrentSideData();
        });
    });
}

function initUploadPanel() {
    var uploadZone = document.getElementById('uploadZone');
    var uploadInput = document.getElementById('uploadInput');
    if (!uploadZone || !uploadInput) return;

    uploadZone.addEventListener('click', function() {
        uploadInput.click();
    });

    uploadInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
            Array.from(e.target.files).forEach(function(file) {
                handleUploadedFile(file);
            });
            uploadInput.value = '';
        }
    });

    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            Array.from(e.dataTransfer.files).forEach(function(file) {
                handleUploadedFile(file);
            });
        }
    });
}

function handleUploadedFile(file) {
    if (!file.type.match(/^image\//)) return;

    var reader = new FileReader();
    reader.onload = function(e) {
        var dataUrl = e.target.result;

        uploadedImages.push({
            name: file.name,
            dataUrl: dataUrl,
            id: 'upload_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5)
        });

        updateUploadPreview();
        addImageToCanvas(dataUrl);
    };
    reader.readAsDataURL(file);
}

function updateUploadPreview() {
    var previewList = document.getElementById('uploadPreviewList');
    if (!previewList) return;

    previewList.innerHTML = '';

    uploadedImages.forEach(function(img, index) {
        var item = document.createElement('div');
        item.className = 'upload-preview-item';
        item.title = img.name;

        var thumb = document.createElement('img');
        thumb.src = img.dataUrl;

        var removeBtn = document.createElement('button');
        removeBtn.className = 'remove-btn';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            uploadedImages.splice(index, 1);
            updateUploadPreview();
        });

        item.appendChild(thumb);
        item.appendChild(removeBtn);

        item.addEventListener('click', function() {
            addImageToCanvas(img.dataUrl);
        });

        previewList.appendChild(item);
    });
}

function addImageToCanvas(dataUrl) {
    fabric.Image.fromURL(dataUrl, function(img) {
        if (img.width > 300) img.scaleToWidth(300);
        if (img.height > 300) img.scaleToHeight(300);

        var cx = canvas.width / 2;
        var cy = canvas.height / 2;

        img.set({
            left: cx - img.getScaledWidth() / 2,
            top: cy - img.getScaledHeight() / 2
        });

        canvas.add(img);
        canvas.setActiveObject(img);
        canvas.renderAll();
    });
}

function updateSelectedTextStyle(obj) {
    if (!obj || !['textbox', 'i-text', 'text'].includes(obj.type)) return;

    document.querySelectorAll('.style-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });

    if (obj.fontWeight === 'bold') {
        var boldBtn = document.querySelector('.style-btn[data-style="bold"]');
        if (boldBtn) boldBtn.classList.add('active');
    }
    if (obj.fontStyle === 'italic') {
        var italicBtn = document.querySelector('.style-btn[data-style="italic"]');
        if (italicBtn) italicBtn.classList.add('active');
    }
    if (obj.underline) {
        var underlineBtn = document.querySelector('.style-btn[data-style="underline"]');
        if (underlineBtn) underlineBtn.classList.add('active');
    }
}

document.addEventListener('keydown', function(e) {
    if ((e.key === 'Delete' || e.key === 'Backspace') && !e.target.closest('input, select, textarea')) {
        const obj = canvas.getActiveObject();
        if (obj) {
            canvas.remove(obj);
            canvas.discardActiveObject().renderAll();
            e.preventDefault();
        }
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
        e.preventDefault();
        undo();
    }
    if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) {
        e.preventDefault();
        redo();
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'c' && !e.target.closest('input, textarea')) {
        e.preventDefault();
        const obj = canvas.getActiveObject();
        if (obj) {
            obj.clone(function(cloned) { copiedObjectJson = cloned.toJSON(); });
        }
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'v' && !e.target.closest('input, textarea')) {
        e.preventDefault();
        if (copiedObjectJson) {
            fabric.util.enlivenObjects([copiedObjectJson], function(objects) {
                const obj = objects[0];
                obj.set({ left: (obj.left || 50) + 30, top: (obj.top || 50) + 30 });
                canvas.add(obj);
                canvas.setActiveObject(obj);
                canvas.renderAll();
            });
        }
    }
});

window.saveDesign = saveDesign;
window.orderDesign = orderDesign;
window.previewDesign = previewDesign;

})();
