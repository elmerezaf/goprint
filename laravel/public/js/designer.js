var canvas;
var currentTool = 'text';
var zoom = 1;
var isGuideVisible = true;
var copiedObjectJson = null;

// Undo/Redo history
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
    });

    canvas.on('object:moving', function(e) {
        updateCoords(e.target);
    });

    canvas.on('object:scaling', function(e) {
        updateCoords(e.target);
    });

    initToolbar();
    initTools();
    initPanels();
    initCanvasControls();
    initEventListeners();

    addDefaultContent();
    saveState();
});

function addDefaultContent() {
    var text = new fabric.Textbox('双击此处编辑文字', {
        left: 50,
        top: 150,
        width: 200,
        fontSize: 24,
        fontFamily: 'Microsoft YaHei',
        fill: '#333333',
        textAlign: 'left'
    });
    canvas.add(text);

    var companyText = new fabric.Text('GoPrint 网上印刷有限公司', {
        left: 280,
        top: 80,
        fontSize: 18,
        fontFamily: 'Microsoft YaHei',
        fill: '#333333',
        fontWeight: 'bold'
    });
    canvas.add(companyText);
}

// ====== Undo / Redo ======
function saveState() {
    var json = JSON.stringify(canvas.toJSON(['id']));
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
        });
        document.getElementById('designStatus').textContent = '未保存';
    }
}

// ====== Toolbar ======
function initToolbar() {
    document.getElementById('btnUndo').addEventListener('click', undo);
    document.getElementById('btnRedo').addEventListener('click', redo);

    document.getElementById('btnCopy').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) {
            obj.clone(function(cloned) {
                copiedObjectJson = cloned.toJSON();
            });
        }
    });

    document.getElementById('btnCut').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
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
                var obj = objects[0];
                obj.set({ left: (obj.left || 50) + 30, top: (obj.top || 50) + 30 });
                canvas.add(obj);
                canvas.setActiveObject(obj);
                canvas.renderAll();
            });
        }
    });

    document.getElementById('btnDelete').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) {
            canvas.remove(obj);
            canvas.discardActiveObject().renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnBringToFront').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) {
            obj.bringToFront();
            canvas.renderAll();
        }
    });

    document.getElementById('btnSendToBack').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) {
            obj.sendToBack();
            canvas.renderAll();
        }
    });

    document.getElementById('btnGroup').addEventListener('click', function() {
        var objs = canvas.getActiveObjects();
        if (objs.length > 1) {
            var group = new fabric.Group(objs, { id: 'group' });
            canvas.discardActiveObject();
            objs.forEach(function(o) { canvas.remove(o); });
            canvas.add(group);
            canvas.setActiveObject(group);
            canvas.renderAll();
        }
    });

    document.getElementById('btnUngroup').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj && obj.type === 'group') {
            var items = obj._objects;
            obj.destroy();
            items.forEach(function(item) { canvas.add(item); });
            canvas.renderAll();
        }
    });

    document.getElementById('btnFlipH').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) { obj.set('flipX', !obj.flipX); canvas.renderAll(); }
    });

    document.getElementById('btnFlipV').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) { obj.set('flipY', !obj.flipY); canvas.renderAll(); }
    });

    document.getElementById('btnRotateL').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) { obj.set('angle', (obj.angle || 0) - 15); canvas.renderAll(); }
    });

    document.getElementById('btnRotateR').addEventListener('click', function() {
        var obj = canvas.getActiveObject();
        if (obj) { obj.set('angle', (obj.angle || 0) + 15); canvas.renderAll(); }
    });
}

// ====== Tools ======
function initTools() {
    var toolButtons = document.querySelectorAll('.tool-btn');
    toolButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            toolButtons.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            currentTool = this.dataset.tool;
            showPanel(currentTool + 'Panel');
        });
    });
}

// ====== Panels ======
function initPanels() {
    // Font size slider
    document.getElementById('fontSize').addEventListener('input', function() {
        document.getElementById('fontSizeValue').textContent = this.value;
        updateSelectedText();
    });
    document.getElementById('fontFamily').addEventListener('change', updateSelectedText);
    document.getElementById('textColor').addEventListener('change', updateSelectedText);

    // Color presets
    document.querySelectorAll('.color-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var color = this.dataset.color;
            var textColor = document.getElementById('textColor');
            textColor.value = color;
            updateSelectedText();

            var bgColor = document.getElementById('bgColor');
            if (bgColor) bgColor.value = color;
        });
    });

    // Text alignment
    document.querySelectorAll('.align-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.align-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            var obj = canvas.getActiveObject();
            if (obj && (obj.type === 'textbox' || obj.type === 'i-text')) {
                obj.set('textAlign', this.dataset.align);
                canvas.renderAll();
            }
        });
    });

    // Shapes
    document.querySelectorAll('.shape-btn').forEach(function(btn) {
        btn.addEventListener('click', function() { addShape(this.dataset.shape); });
    });
    document.getElementById('shapeFill').addEventListener('change', updateSelectedShape);
    document.getElementById('shapeStroke').addEventListener('change', updateSelectedShape);
    document.getElementById('shapeStrokeWidth').addEventListener('input', updateSelectedShape);

    // Image upload
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        if (e.target.files[0]) uploadImage(e.target.files[0]);
    });
    document.getElementById('imageOpacity').addEventListener('input', function() {
        var obj = canvas.getActiveObject();
        if (obj && obj.type === 'image') {
            obj.set('opacity', this.value / 100);
            canvas.renderAll();
        }
    });

    // Background
    document.getElementById('bgColor').addEventListener('change', function() {
        canvas.setBackgroundColor(this.value, function() { canvas.renderAll(); });
    });
    document.getElementById('bgImageUpload').addEventListener('change', function(e) {
        if (e.target.files[0]) setBackgroundImage(e.target.files[0]);
    });

    // Templates
    document.querySelectorAll('.template-item').forEach(function(item) {
        item.addEventListener('click', function() {
            loadTemplate(
                parseFloat(this.dataset.width),
                parseFloat(this.dataset.height),
                this.dataset.bg
            );
        });
    });
}

// ====== Canvas Controls ======
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
    document.getElementById('toggleGuide').addEventListener('click', function() {
        isGuideVisible = !isGuideVisible;
        document.getElementById('cuttingGuide').style.display = isGuideVisible ? 'block' : 'none';
    });
}

// ====== Event Listeners ======
function initEventListeners() {
    canvas.on('mouse:move', function(e) {
        if (e.pointer) {
            document.getElementById('coordDisplay').textContent =
                'X: ' + Math.round(e.pointer.x) + ', Y: ' + Math.round(e.pointer.y);
        }
    });

    canvas.on('object:modified', function() {
        document.getElementById('designStatus').textContent = '未保存';
    });

    document.getElementById('btnPreview').addEventListener('click', previewDesign);
    document.getElementById('btnSave').addEventListener('click', saveDesign);
    document.getElementById('btnOrder').addEventListener('click', orderDesign);
}

// ====== Zoom ======
function updateZoom() {
    canvas.setZoom(zoom);
    document.getElementById('zoomLevel').textContent = Math.round(zoom * 100) + '%';
}

// ====== Panel Show ======
function showPanel(panelId) {
    document.querySelectorAll('.panel-section').forEach(function(p) { p.style.display = 'none'; });
    var el = document.getElementById(panelId);
    if (el) el.style.display = 'block';
}

// ====== Shapes ======
function addShape(type) {
    var cx = canvas.width / 2, cy = canvas.height / 2;
    var fill = document.getElementById('shapeFill').value;
    var stroke = document.getElementById('shapeStroke').value;
    var sw = parseInt(document.getElementById('shapeStrokeWidth').value) || 1;
    var shape;

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
    }

    if (shape) {
        canvas.add(shape);
        canvas.setActiveObject(shape);
        canvas.renderAll();
    }
}

// ====== Image ======
function uploadImage(file) {
    var reader = new FileReader();
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

// ====== Background ======
function setBackgroundImage(file) {
    var reader = new FileReader();
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

// ====== Template ======
function loadTemplate(width, height, bgColor) {
    canvas.clear();
    canvas.setBackgroundColor(bgColor || '#ffffff', function() { canvas.renderAll(); });

    var mmToPx = 6.67;
    var newWidth = Math.round(width * mmToPx);
    var newHeight = Math.round(height * mmToPx);
    canvas.setWidth(newWidth);
    canvas.setHeight(newHeight);

    document.getElementById('canvasSize').textContent = width + 'mm x ' + height + 'mm';

    zoom = 1;
    updateZoom();
    document.getElementById('designStatus').textContent = '未保存';
    historyStack = [];
    historyIndex = -1;
    addDefaultContent();
    canvas.renderAll();
}

// ====== Update Selected Object ======
function updateSelectedText() {
    var obj = canvas.getActiveObject();
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
    var obj = canvas.getActiveObject();
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
}

function updateCoords(object) {
    if (object) {
        document.getElementById('coordDisplay').textContent =
            'X: ' + Math.round(object.left || 0) + ', Y: ' + Math.round(object.top || 0) +
            ' | W: ' + Math.round((object.width || 0) * (object.scaleX || 1)) +
            ', H: ' + Math.round((object.height || 0) * (object.scaleY || 1));
    }
}

// ====== Preview ======
function previewDesign() {
    var dataURL = canvas.toDataURL({ format: 'png', quality: 1 });
    var w = window.open('', '_blank');
    if (!w) { alert('请允许弹出窗口以预览设计'); return; }
    w.document.write('<html><head><title>设计预览 - GoPrint</title>');
    w.document.write('<style>body{margin:0;display:flex;justify-content:center;align-items:center;background:#f5f5f5;min-height:100vh;font-family:sans-serif;}</style></head>');
    w.document.write('<body><img src="' + dataURL + '" style="max-width:95%;max-height:95%;box-shadow:0 4px 20px rgba(0,0,0,0.2);border-radius:4px;"></body></html>');
    w.document.close();
}

// ====== Save ======
function saveDesign() {
    var data = canvas.toJSON();
    var blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'goprint_design_' + Date.now() + '.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    document.getElementById('designStatus').textContent = '已保存';
    setTimeout(function() { document.getElementById('designStatus').textContent = '未保存'; }, 2000);
}

// ====== Order ======
function orderDesign() {
    var designData = canvas.toJSON();
    var productId = document.getElementById('productId').value;
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) { alert('CSRF token missing, please refresh the page'); return; }

    var formData = new FormData();
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

// ====== Keyboard Shortcuts ======
document.addEventListener('keydown', function(e) {
    // Delete
    if ((e.key === 'Delete' || e.key === 'Backspace') && !e.target.closest('input, select, textarea')) {
        var obj = canvas.getActiveObject();
        if (obj) {
            canvas.remove(obj);
            canvas.discardActiveObject().renderAll();
            e.preventDefault();
        }
    }

    // Ctrl+Z undo
    if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
        e.preventDefault();
        undo();
    }

    // Ctrl+Y or Ctrl+Shift+Z redo
    if ((e.ctrlKey || e.metaKey) && (e.key === 'y' || (e.key === 'z' && e.shiftKey))) {
        e.preventDefault();
        redo();
    }

    // Ctrl+C copy
    if ((e.ctrlKey || e.metaKey) && e.key === 'c' && !e.target.closest('input, textarea')) {
        e.preventDefault();
        var obj = canvas.getActiveObject();
        if (obj) {
            obj.clone(function(cloned) { copiedObjectJson = cloned.toJSON(); });
        }
    }

    // Ctrl+V paste
    if ((e.ctrlKey || e.metaKey) && e.key === 'v' && !e.target.closest('input, textarea')) {
        e.preventDefault();
        if (copiedObjectJson) {
            fabric.util.enlivenObjects([copiedObjectJson], function(objects) {
                var obj = objects[0];
                obj.set({ left: (obj.left || 50) + 30, top: (obj.top || 50) + 30 });
                canvas.add(obj);
                canvas.setActiveObject(obj);
                canvas.renderAll();
            });
        }
    }
});
