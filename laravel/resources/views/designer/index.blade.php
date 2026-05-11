<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在线设计器 - GoPrint</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/designer.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
</head>
<body>
    <div class="designer-container">
        <header class="designer-header">
            <div class="header-left">
                <button class="btn btn-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h1 class="logo">GoPrint Designer</h1>
            </div>
            <div class="header-center">
                <span class="canvas-size" id="canvasSize">90mm x 54mm</span>
                <span class="design-status" id="designStatus">未保存</span>
            </div>
            <div class="header-right">
                <button class="btn btn-outline-secondary" id="btnPreview">
                    <i class="fas fa-eye"></i> 预览
                </button>
                <button class="btn btn-outline-secondary" id="btnSave">
                    <i class="fas fa-save"></i> 保存
                </button>
                <button class="btn btn-primary" id="btnOrder">
                    <i class="fas fa-shopping-cart"></i> 下单
                </button>
            </div>
        </header>

        <div class="designer-main">
            <aside class="left-panel">
                <div class="tool-group">
                    <button class="tool-btn active" data-tool="text" title="文字">
                        <i class="fas fa-font"></i>
                        <span>文字</span>
                    </button>
                    <button class="tool-btn" data-tool="shape" title="形状">
                        <i class="fas fa-square"></i>
                        <span>形状</span>
                    </button>
                    <button class="tool-btn" data-tool="image" title="图片">
                        <i class="fas fa-image"></i>
                        <span>图片</span>
                    </button>
                    <button class="tool-btn" data-tool="background" title="背景">
                        <i class="fas fa-palette"></i>
                        <span>背景</span>
                    </button>
                    <button class="tool-btn" data-tool="template" title="模板">
                        <i class="fas fa-layer-group"></i>
                        <span>模板</span>
                    </button>
                    <button class="tool-btn" data-tool="layers" title="图层">
                        <i class="fas fa-layer-group"></i>
                        <span>图层</span>
                    </button>
                    <button class="tool-btn" data-tool="upload" title="上传">
                        <i class="fas fa-upload"></i>
                        <span>上传</span>
                    </button>
                </div>
            </aside>

            <main class="canvas-area">
                <div class="canvas-wrapper" id="canvasWrapper">
                    <canvas id="designCanvas" width="600" height="360"></canvas>
                    <div class="cutting-guide" id="cuttingGuide"></div>
                </div>
                <div class="canvas-controls">
                    <button class="zoom-btn" id="zoomOut" title="缩小">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <span class="zoom-level" id="zoomLevel">100%</span>
                    <button class="zoom-btn" id="zoomIn" title="放大">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button class="zoom-btn" id="zoomReset" title="重置">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="zoom-btn" id="toggleGuide" title="切换裁切框">
                        <i class="fas fa-border-all"></i>
                    </button>
                </div>
            </main>

            <aside class="right-panel" id="rightPanel">
                <div class="panel-section" id="textPanel">
                    <h3 class="panel-title">文字设置</h3>
                    <div class="form-group">
                        <label>字体</label>
                        <select id="fontFamily" class="form-control">
                            @foreach($fonts as $font)
                                <option value="{{ $font['name'] }}">{{ $font['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>字号</label>
                        <input type="range" id="fontSize" min="8" max="72" value="24">
                        <span id="fontSizeValue">24</span>
                    </div>
                    <div class="form-group">
                        <label>颜色</label>
                        <div class="color-picker">
                            <input type="color" id="textColor" value="#333333">
                            <div class="color-presets">
                                @foreach($colors as $color)
                                    <button class="color-btn" style="background: {{ $color }}" data-color="{{ $color }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>对齐</label>
                        <div class="align-buttons">
                            <button class="align-btn active" data-align="left"><i class="fas fa-align-left"></i></button>
                            <button class="align-btn" data-align="center"><i class="fas fa-align-center"></i></button>
                            <button class="align-btn" data-align="right"><i class="fas fa-align-right"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>样式</label>
                        <div class="style-buttons">
                            <button class="style-btn" data-style="bold"><i class="fas fa-bold"></i></button>
                            <button class="style-btn" data-style="italic"><i class="fas fa-italic"></i></button>
                            <button class="style-btn" data-style="underline"><i class="fas fa-underline"></i></button>
                        </div>
                    </div>
                </div>

                <div class="panel-section" id="shapePanel" style="display: none;">
                    <h3 class="panel-title">形状设置</h3>
                    <div class="shape-buttons">
                        @foreach($shapes as $shape)
                            <button class="shape-btn" data-shape="{{ $shape['type'] }}" title="{{ $shape['name'] }}">
                                <i class="fas fa-{{ $shape['icon'] }}"></i>
                            </button>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label>填充颜色</label>
                        <input type="color" id="shapeFill" value="#3498db">
                    </div>
                    <div class="form-group">
                        <label>边框颜色</label>
                        <input type="color" id="shapeStroke" value="#333333">
                    </div>
                    <div class="form-group">
                        <label>边框宽度</label>
                        <input type="range" id="shapeStrokeWidth" min="0" max="10" value="1">
                    </div>
                </div>

                <div class="panel-section" id="imagePanel" style="display: none;">
                    <h3 class="panel-title">图片设置</h3>
                    <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                    <button class="btn btn-primary w-100" onclick="document.getElementById('imageUpload').click()">
                        <i class="fas fa-upload"></i> 上传图片
                    </button>
                    <div class="form-group mt-3">
                        <label>透明度</label>
                        <input type="range" id="imageOpacity" min="0" max="100" value="100">
                    </div>
                </div>

                <div class="panel-section" id="backgroundPanel" style="display: none;">
                    <h3 class="panel-title">背景设置</h3>
                    <div class="form-group">
                        <label>背景颜色</label>
                        <div class="color-picker">
                            <input type="color" id="bgColor" value="#ffffff">
                            <div class="color-presets">
                                @foreach($colors as $color)
                                    <button class="color-btn" style="background: {{ $color }}" data-color="{{ $color }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>背景图片</label>
                        <input type="file" id="bgImageUpload" accept="image/*" style="display: none;">
                        <button class="btn btn-outline-secondary w-100" onclick="document.getElementById('bgImageUpload').click()">
                            <i class="fas fa-image"></i> 选择图片
                        </button>
                    </div>
                </div>

                <div class="panel-section" id="templatePanel" style="display: none;">
                    <h3 class="panel-title">选择模板</h3>
                    <div class="template-grid">
                        @foreach($templates as $template)
                            <div class="template-item" data-template="{{ $template['id'] }}" 
                                 data-width="{{ $template['width'] }}" 
                                 data-height="{{ $template['height'] }}"
                                 data-bg="{{ $template['background'] }}">
                                <img src="{{ $template['preview'] }}" alt="{{ $template['name'] }}">
                                <span>{{ $template['name'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="panel-section" id="layersPanel" style="display: none;">
                    <h3 class="panel-title">图层</h3>
                    <div class="layers-list" id="layersList">
                        <p class="text-muted">选择一个元素查看图层</p>
                    </div>
                </div>
            </aside>
        </div>

        <div class="designer-toolbar">
            <div class="toolbar-left">
                <button class="toolbar-btn" id="btnUndo" title="撤销">
                    <i class="fas fa-undo"></i>
                </button>
                <button class="toolbar-btn" id="btnRedo" title="重做">
                    <i class="fas fa-redo"></i>
                </button>
                <div class="toolbar-divider"></div>
                <button class="toolbar-btn" id="btnCopy" title="复制">
                    <i class="fas fa-copy"></i>
                </button>
                <button class="toolbar-btn" id="btnCut" title="剪切">
                    <i class="fas fa-cut"></i>
                </button>
                <button class="toolbar-btn" id="btnPaste" title="粘贴">
                    <i class="fas fa-paste"></i>
                </button>
                <div class="toolbar-divider"></div>
                <button class="toolbar-btn" id="btnDelete" title="删除">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="toolbar-center">
                <button class="toolbar-btn" id="btnBringToFront" title="置于顶层">
                    <i class="fas fa-layer-group"></i>
                </button>
                <button class="toolbar-btn" id="btnSendToBack" title="置于底层">
                    <i class="fas fa-layer-group"></i>
                </button>
                <div class="toolbar-divider"></div>
                <button class="toolbar-btn" id="btnGroup" title="组合">
                    <i class="fas fa-object-group"></i>
                </button>
                <button class="toolbar-btn" id="btnUngroup" title="取消组合">
                    <i class="fas fa-object-ungroup"></i>
                </button>
            </div>

            <div class="toolbar-right">
                <button class="toolbar-btn" id="btnFlipH" title="水平翻转">
                    <i class="fas fa-arrows-h"></i>
                </button>
                <button class="toolbar-btn" id="btnFlipV" title="垂直翻转">
                    <i class="fas fa-arrows-v"></i>
                </button>
                <button class="toolbar-btn" id="btnRotateL" title="向左旋转">
                    <i class="fas fa-rotate-left"></i>
                </button>
                <button class="toolbar-btn" id="btnRotateR" title="向右旋转">
                    <i class="fas fa-rotate-right"></i>
                </button>
                <div class="toolbar-divider"></div>
                <span class="coord-display" id="coordDisplay">X: 0, Y: 0</span>
            </div>
        </div>
    </div>

    <input type="hidden" id="productId" value="{{ $productId ?? '' }}">
    <script src="{{ asset('js/designer.js') }}"></script>
</body>
</html>