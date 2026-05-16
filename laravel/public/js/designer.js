var canvas;
var currentTool = 'text';
var zoom = 1;
var isGuideVisible = true;
var copiedObjectJson = null;
var currentSide = 'front';
var sideData = {
    front: null,
    back: null
};
var historyStack = [];
var historyIndex = -1;
var isRestoring = false;

document.addEventListener('DOMContentLoaded', function() {
    canvas = new fabric.Canvas('designCanvas', {
        width: 600,
        height: 360,
        backgroundColor: '#ffffff',
        preserveObjectStacking: true
    });

    canvas.on('object:modified', function() {
        if (!isRestoring) saveState();
    });

    canvas.on('object:added', function(e) {
        if (!isRestoring && !e.e) saveState();
    });

    canvas.on('object:removed', function() {
        if (!isRestoring) saveState();
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

    canvas.on('object:modified', function() {
        updateLayersList();
    });

    canvas.on('object:added', function() {
        updateLayersList();
    });

    canvas.on('object:removed', function() {
        updateLayersList();
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

    // Initialize front side
    addDefaultContent();
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
    
    // Create a list of gradient color pairs
    const gradients = {
        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)': ['#667eea', '#764ba2'],
        'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)': ['#f093fb', '#f5576c'],
        'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)': ['#4facfe', '#00f2fe'],
        'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)': ['#43e97b', '#38f9d7'],
        'linear-gradient(135deg, #fa709a 0%, #fee140 100%)': ['#fa709a', '#fee140'],
        'linear-gradient(135deg, #30cfd0 0%, #330867 100%)': ['#30cfd0', '#330867'],
        'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)': ['#a8edea', '#fed6e3'],
        'linear-gradient(135deg, #d299c2 0%, #fef9d7 100%)': ['#d299c2', '#fef9d7'],
        'linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%)': ['#89f7fe', '#66a6ff'],
        'linear-gradient(135deg, #fddb92 0%, #d1fdff 100%)': ['#fddb92', '#d1fdff'],
        'linear-gradient(135deg, #f6d365 0%, #fda085 100%)': ['#f6d365', '#fda085'],
        'linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)': ['#a1c4fd', '#c2e9fb']
    };
    
    let colors = gradients[gradientCss];
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
    
    const companyText = new fabric.Text('GoPrint 网上印刷有限公司', {
        left: 280,
        top: 80,
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
    canvas.on('object:modified', function() {
        document.getElementById('designStatus').textContent = '未保存';
        updateLayersList();
    });
    document.getElementById('btnPreview').addEventListener('click', previewDesign);
    document.getElementById('btnSave').addEventListener('click', saveDesign);
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
    const reader = new FileReader();
    reader.onload = function(e) {
        fabric.Image.fromURL(e.target.result, function(img) {
            canvas.setBackgroundImage(img, function() {
                canvas.renderAll();
            }, {
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height
            });
        });
    };
    reader.readAsDataURL(file);
}

function loadTemplate(svgContent, width, height, bgColor) {
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
                        const x = (subObj.left || 0) * scaleX;
                        const y = (subObj.top || 0) * scaleY;
                        subObj.set({
                            left: x,
                            top: y,
                            scaleX: (subObj.scaleX || 1),
                            scaleY: (subObj.scaleY || 1),
                            selectable: true,
                            evented: true,
                            hasControls: true,
                            hasBorders: true
                        });
                        if (subObj.type === 'text' || subObj.type === 'textbox') {
                            subObj.fontFamily = subObj.fontFamily || 'Microsoft YaHei';
                            subObj.fontSize = (subObj.fontSize || 12) * scaleX;
                        }
                        canvas.add(subObj);
                    });
                } else {
                    const x = (obj.left || 0) * scaleX;
                    const y = (obj.top || 0) * scaleY;
                    obj.set({
                        left: x,
                        top: y,
                        scaleX: (obj.scaleX || 1),
                        scaleY: (obj.scaleY || 1),
                        selectable: true,
                        evented: true,
                        hasControls: true,
                        hasBorders: true
                    });
                    if (obj.type === 'text' || obj.type === 'textbox') {
                        obj.fontFamily = obj.fontFamily || 'Microsoft YaHei';
                        obj.fontSize = (obj.fontSize || 12) * scaleX;
                    }
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
        const icon = document.createElement('i');
        const typeName = obj.type || 'unknown';
        if (typeName === 'textbox' || typeName === 'i-text' || typeName === 'text') icon.className = 'fas fa-font';
        else if (typeName === 'image') icon.className = 'fas fa-image';
        else if (typeName === 'group') icon.className = 'fas fa-object-group';
        else icon.className = 'fas fa-shape';
        item.appendChild(icon);
        const name = document.createElement('span');
        name.textContent = typeName + ' ' + (i + 1);
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
        localStorage.setItem('goprint_design_autosave', JSON.stringify(data));
        const statusEl = document.getElementById('designStatus');
        statusEl.textContent = '自动保存...';
        statusEl.style.color = '#2ecc71';
        setTimeout(function() {
            if (statusEl.textContent === '自动保存...') {
                statusEl.textContent = '未保存';
                statusEl.style.color = '#e74c3c';
            }
        }, 2000);
    } catch(e) {}
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
    w.document.write('<html><head><title>设计预览 - GoPrint</title>');
    w.document.write('<style>body{margin:0;display:flex;justify-content:center;align-items:center;background:#f5f5f5;min-height:100vh;font-family:sans-serif;}</style></head>');
    w.document.write('<body><img src="' + dataURL + '" style="max-width:95%;max-height:95%;box-shadow:0 4px 20px rgba(0,0,0,0.2);border-radius:4px;"></body></html>');
    w.document.close();
}

function saveDesign() {
    saveCurrentSideData();
    const data = {
        front: sideData.front,
        back: sideData.back
    };
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'goprint_design_' + Date.now() + '.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    document.getElementById('designStatus').textContent = '已保存';
    setTimeout(function() { document.getElementById('designStatus').textContent = '未保存'; }, 2000);
}

function orderDesign() {
    saveCurrentSideData();
    const designData = {
        front: sideData.front,
        back: sideData.back
    };
    const productId = document.getElementById('productId').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) { alert('CSRF token missing, please refresh the page'); return; }
    const formData = new FormData();
    formData.append('design_data', JSON.stringify(designData));
    formData.append('product_id', productId);
    fetch('/designer/export', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken.content },
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            alert('设计已保存，正在跳转到下单页面...');
            window.location.href = '/order/create';
        } else {
            alert('保存失败：' + (data.message || '未知错误'));
        }
    })
    .catch(function(err) {
        console.error('Save error:', err);
        alert('保存失败，请检查网络连接后重试');
    });
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
