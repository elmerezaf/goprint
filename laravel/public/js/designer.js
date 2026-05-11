var canvas;
var currentTool = 'text';
var zoom = 1;
var isGuideVisible = true;
var copiedObjects = [];

document.addEventListener('DOMContentLoaded', function() {
    canvas = new fabric.Canvas('designCanvas', {
        width: 600,
        height: 360,
        backgroundColor: '#ffffff',
        preserveObjectStacking: true,
        stateful: true
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

    canvas.on('after:render', function() {
        canvas.renderAll();
    });

    initToolbar();
    initTools();
    initPanels();
    initCanvasControls();
    initEventListeners();

    addDefaultContent();
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

function initToolbar() {
    document.getElementById('btnUndo').addEventListener('click', function() {
        if (canvas.getActiveObject()) {
            canvas.getActiveObject().undo();
        } else {
            canvas.undo();
        }
        canvas.renderAll();
    });

    document.getElementById('btnRedo').addEventListener('click', function() {
        if (canvas.getActiveObject()) {
            canvas.getActiveObject().redo();
        } else {
            canvas.redo();
        }
        canvas.renderAll();
    });

    document.getElementById('btnCopy').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            copiedObjects = [JSON.stringify(activeObject.toJSON())];
        } else if (canvas.getActiveObjects().length > 0) {
            copiedObjects = canvas.getActiveObjects().map(function(obj) {
                return JSON.stringify(obj.toJSON());
            });
        }
    });

    document.getElementById('btnCut').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            copiedObjects = [JSON.stringify(activeObject.toJSON())];
            canvas.remove(activeObject);
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnPaste').addEventListener('click', function() {
        if (copiedObjects.length > 0) {
            copiedObjects.forEach(function(objJson) {
                fabric.loadFromJSON(objJson, function(o) {
                    o.set({
                        left: o.left + 20,
                        top: o.top + 20
                    });
                    canvas.add(o);
                    canvas.renderAll();
                });
            });
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnDelete').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.remove(activeObject);
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnBringToFront').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            activeObject.bringToFront();
            canvas.renderAll();
        }
    });

    document.getElementById('btnSendToBack').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            activeObject.sendToBack();
            canvas.renderAll();
        }
    });

    document.getElementById('btnGroup').addEventListener('click', function() {
        var activeObjects = canvas.getActiveObjects();
        if (activeObjects.length > 1) {
            var group = new fabric.Group(activeObjects);
            canvas.add(group);
            canvas.setActiveObject(group);
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnUngroup').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'group') {
            activeObject.destroy();
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnFlipH').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            activeObject.set('flipX', !activeObject.flipX);
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnFlipV').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            activeObject.set('flipY', !activeObject.flipY);
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnRotateL').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            activeObject.set('angle', activeObject.angle - 15);
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('btnRotateR').addEventListener('click', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            activeObject.set('angle', activeObject.angle + 15);
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });
}

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

function initPanels() {
    document.getElementById('fontSize').addEventListener('input', function() {
        document.getElementById('fontSizeValue').textContent = this.value;
        updateSelectedText();
    });

    document.getElementById('fontFamily').addEventListener('change', updateSelectedText);
    document.getElementById('textColor').addEventListener('change', updateSelectedText);

    document.querySelectorAll('.color-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var color = this.dataset.color;
            var activeInput = document.querySelector('.color-picker input[type="color"]:focus') ||
                            document.getElementById('textColor');
            activeInput.value = color;
            updateSelectedText();
        });
    });

    document.querySelectorAll('.align-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.align-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            var align = this.dataset.align;
            var activeObject = canvas.getActiveObject();
            if (activeObject && activeObject.type === 'textbox') {
                activeObject.set('textAlign', align);
                canvas.renderAll();
                document.getElementById('designStatus').textContent = '未保存';
            }
        });
    });

    document.querySelectorAll('.shape-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var shapeType = this.dataset.shape;
            addShape(shapeType);
        });
    });

    document.getElementById('shapeFill').addEventListener('change', updateSelectedShape);
    document.getElementById('shapeStroke').addEventListener('change', updateSelectedShape);
    document.getElementById('shapeStrokeWidth').addEventListener('input', updateSelectedShape);

    document.getElementById('imageUpload').addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            uploadImage(file);
        }
    });

    document.getElementById('imageOpacity').addEventListener('input', function() {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'image') {
            activeObject.set('opacity', this.value / 100);
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        }
    });

    document.getElementById('bgColor').addEventListener('change', function() {
        canvas.setBackgroundColor(this.value, function() {
            canvas.renderAll();
            document.getElementById('designStatus').textContent = '未保存';
        });
    });

    document.getElementById('bgImageUpload').addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            setBackgroundImage(file);
        }
    });

    document.querySelectorAll('.template-item').forEach(function(item) {
        item.addEventListener('click', function() {
            var width = parseFloat(this.dataset.width);
            var height = parseFloat(this.dataset.height);
            var bg = this.dataset.bg;
            loadTemplate(width, height, bg);
        });
    });
}

function initCanvasControls() {
    document.getElementById('zoomIn').addEventListener('click', function() {
        zoom += 0.1;
        updateZoom();
    });

    document.getElementById('zoomOut').addEventListener('click', function() {
        zoom = Math.max(0.5, zoom - 0.1);
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

function initEventListeners() {
    canvas.on('mouse:move', function(e) {
        if (e.pointer) {
            var pointer = canvas.getPointer(e.e);
            document.getElementById('coordDisplay').textContent = 
                'X: ' + Math.round(pointer.x) + ', Y: ' + Math.round(pointer.y);
        }
    });

    canvas.on('object:added', function() {
        document.getElementById('designStatus').textContent = '未保存';
    });

    canvas.on('object:removed', function() {
        document.getElementById('designStatus').textContent = '未保存';
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
    document.querySelectorAll('.panel-section').forEach(function(panel) {
        panel.style.display = 'none';
    });
    document.getElementById(panelId).style.display = 'block';
}

function addShape(type) {
    var centerX = canvas.width / 2;
    var centerY = canvas.height / 2;
    var shape;

    switch(type) {
        case 'rect':
            shape = new fabric.Rect({
                left: centerX - 50,
                top: centerY - 30,
                width: 100,
                height: 60,
                fill: document.getElementById('shapeFill').value,
                stroke: document.getElementById('shapeStroke').value,
                strokeWidth: parseInt(document.getElementById('shapeStrokeWidth').value)
            });
            break;
        case 'circle':
            shape = new fabric.Circle({
                left: centerX - 40,
                top: centerY - 40,
                radius: 40,
                fill: document.getElementById('shapeFill').value,
                stroke: document.getElementById('shapeStroke').value,
                strokeWidth: parseInt(document.getElementById('shapeStrokeWidth').value)
            });
            break;
        case 'triangle':
            shape = new fabric.Triangle({
                left: centerX - 50,
                top: centerY - 40,
                width: 100,
                height: 80,
                fill: document.getElementById('shapeFill').value,
                stroke: document.getElementById('shapeStroke').value,
                strokeWidth: parseInt(document.getElementById('shapeStrokeWidth').value)
            });
            break;
        case 'line':
            shape = new fabric.Line([centerX - 50, centerY, centerX + 50, centerY], {
                stroke: document.getElementById('shapeStroke').value,
                strokeWidth: parseInt(document.getElementById('shapeStrokeWidth').value)
            });
            break;
    }

    if (shape) {
        canvas.add(shape);
        canvas.setActiveObject(shape);
        document.getElementById('designStatus').textContent = '未保存';
    }
}

function uploadImage(file) {
    var reader = new FileReader();
    reader.onload = function(e) {
        fabric.Image.fromURL(e.target.result, function(img) {
            img.scaleToWidth(200);
            img.set({
                left: (canvas.width - img.width) / 2,
                top: (canvas.height - img.height) / 2
            });
            canvas.add(img);
            canvas.setActiveObject(img);
            document.getElementById('designStatus').textContent = '未保存';
        });
    };
    reader.readAsDataURL(file);
}

function setBackgroundImage(file) {
    var reader = new FileReader();
    reader.onload = function(e) {
        fabric.Image.fromURL(e.target.result, function(img) {
            canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height
            });
            document.getElementById('designStatus').textContent = '未保存';
        });
    };
    reader.readAsDataURL(file);
}

function loadTemplate(width, height, bgColor) {
    canvas.clear();
    canvas.setBackgroundColor(bgColor, function() {
        canvas.renderAll();
    });
    
    var mmToPx = 6.67;
    var newWidth = width * mmToPx;
    var newHeight = height * mmToPx;
    
    canvas.setWidth(newWidth);
    canvas.setHeight(newHeight);
    
    document.getElementById('canvasSize').textContent = width + 'mm x ' + height + 'mm';
    document.getElementById('designStatus').textContent = '未保存';
    
    zoom = 1;
    updateZoom();
}

function updateSelectedText() {
    var activeObject = canvas.getActiveObject();
    if (activeObject && (activeObject.type === 'textbox' || activeObject.type === 'text')) {
        activeObject.set({
            fontSize: parseInt(document.getElementById('fontSize').value),
            fontFamily: document.getElementById('fontFamily').value,
            fill: document.getElementById('textColor').value
        });
        canvas.renderAll();
        document.getElementById('designStatus').textContent = '未保存';
    }
}

function updateSelectedShape() {
    var activeObject = canvas.getActiveObject();
    if (activeObject && activeObject.type !== 'text' && activeObject.type !== 'textbox' && activeObject.type !== 'image') {
        activeObject.set({
            fill: document.getElementById('shapeFill').value,
            stroke: document.getElementById('shapeStroke').value,
            strokeWidth: parseInt(document.getElementById('shapeStrokeWidth').value)
        });
        canvas.renderAll();
        document.getElementById('designStatus').textContent = '未保存';
    }
}

function updateRightPanel(object) {
    if (!object) return;

    if (object.type === 'textbox' || object.type === 'text') {
        showPanel('textPanel');
        document.getElementById('fontSize').value = object.fontSize || 24;
        document.getElementById('fontSizeValue').textContent = object.fontSize || 24;
        document.getElementById('fontFamily').value = object.fontFamily || 'Microsoft YaHei';
        document.getElementById('textColor').value = object.fill || '#333333';
    } else if (object.type === 'image') {
        showPanel('imagePanel');
        document.getElementById('imageOpacity').value = Math.round(object.opacity * 100);
    }
}

function updateCoords(object) {
    if (object) {
        document.getElementById('coordDisplay').textContent = 
            'X: ' + Math.round(object.left) + ', Y: ' + Math.round(object.top) +
            ' | W: ' + Math.round(object.width * object.scaleX) + ', H: ' + Math.round(object.height * object.scaleY);
    }
}

function previewDesign() {
    var dataURL = canvas.toDataURL({
        format: 'png',
        quality: 1
    });
    
    var previewWindow = window.open('', '_blank');
    previewWindow.document.write('<html><head><title>设计预览</title></head>');
    previewWindow.document.write('<body style="margin:0;display:flex;justify-content:center;align-items:center;background:#f5f5f5;height:100vh;">');
    previewWindow.document.write('<img src="' + dataURL + '" style="max-width:90%;max-height:90%;box-shadow:0 4px 20px rgba(0,0,0,0.2);">');
    previewWindow.document.write('</body></html>');
    previewWindow.document.close();
}

function saveDesign() {
    var data = canvas.toJSON();
    var dataStr = JSON.stringify(data, null, 2);
    
    var blob = new Blob([dataStr], { type: 'application/json' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'design_' + Date.now() + '.json';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    document.getElementById('designStatus').textContent = '已保存';
    setTimeout(function() {
        document.getElementById('designStatus').textContent = '未保存';
    }, 2000);
}

function orderDesign() {
    var designData = canvas.toJSON();
    var productId = document.getElementById('productId').value;
    
    var formData = new FormData();
    formData.append('design_data', JSON.stringify(designData));
    formData.append('product_id', productId);
    
    fetch('/designer/export', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('设计已保存，正在跳转到下单页面...');
            window.location.href = '/order/create';
        }
    })
    .catch(error => {
        console.error('保存失败:', error);
        alert('保存失败，请重试');
    });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Delete' || e.key === 'Backspace') {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.remove(activeObject);
            document.getElementById('designStatus').textContent = '未保存';
        }
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'z') {
        e.preventDefault();
        if (canvas.getActiveObject()) {
            canvas.getActiveObject().undo();
        } else {
            canvas.undo();
        }
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'y') {
        e.preventDefault();
        if (canvas.getActiveObject()) {
            canvas.getActiveObject().redo();
        } else {
            canvas.redo();
        }
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
        e.preventDefault();
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            copiedObjects = [JSON.stringify(activeObject.toJSON())];
        }
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'v') {
        e.preventDefault();
        if (copiedObjects.length > 0) {
            copiedObjects.forEach(function(objJson) {
                fabric.loadFromJSON(objJson, function(o) {
                    o.set({
                        left: o.left + 20,
                        top: o.top + 20
                    });
                    canvas.add(o);
                    canvas.renderAll();
                });
            });
            document.getElementById('designStatus').textContent = '未保存';
        }
    }
});