<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>在线设计器 - GoPrint</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/designer.css') }}?v={{ filemtime(public_path('css/designer.css')) }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                <div class="side-switcher">
                    <button class="side-btn active" id="btnFrontSide">正面</button>
                    <button class="side-btn" id="btnBackSide">背面</button>
                </div>
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
                        <i class="fas fa-object-group"></i>
                        <span>模板</span>
                    </button>
                    <button class="tool-btn" data-tool="layers" title="图层">
                        <i class="fas fa-list"></i>
                        <span>图层</span>
                    </button>
                    <button class="tool-btn" data-tool="qrcode" title="二维码">
                        <i class="fas fa-qrcode"></i>
                        <span>二维码</span>
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
                    <select id="zoomPreset" class="zoom-preset" title="缩放预设">
                        <option value="0.5">50%</option>
                        <option value="0.75">75%</option>
                        <option value="1" selected>100%</option>
                        <option value="1.5">150%</option>
                        <option value="2">200%</option>
                    </select>
                    
                </div>
            </main>

            <aside class="right-panel" id="rightPanel">
                <div class="panel-section" id="textPanel">
                    <h3 class="panel-title">文字设置</h3>
                    <div class="form-group">
                        <button class="btn btn-primary w-100 mb-3" id="btnAddText">
                            <i class="fas fa-plus"></i> 添加文字
                        </button>
                    </div>
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
                        <label>背景类型</label>
                        <div class="bg-type-tabs">
                            <button class="bg-type-tab active" data-type="solid">纯色</button>
                            <button class="bg-type-tab" data-type="gradient">渐变</button>
                            <button class="bg-type-tab" data-type="image">图片</button>
                        </div>
                    </div>
                    <div class="bg-solid-section">
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
                    </div>
                    <div class="bg-gradient-section" style="display: none;">
                        <div class="form-group">
                            <label>预设渐变</label>
                            <div class="gradient-presets" id="gradientPresets">
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #667eea 0%, #764ba2 100%)" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #f093fb 0%, #f5576c 100%)" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #fa709a 0%, #fee140 100%)" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #30cfd0 0%, #330867 100%)" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #d299c2 0%, #fef9d7 100%)" style="background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%)" style="background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #fddb92 0%, #d1fdff 100%)" style="background: linear-gradient(135deg, #fddb92 0%, #d1fdff 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #f6d365 0%, #fda085 100%)" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></button>
                                <button class="gradient-btn" data-gradient="linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);"></button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-image-section" style="display: none;">
                        <div class="form-group">
                            <label>背景图片</label>
                            <input type="file" id="bgImageUpload" accept="image/*" style="display: none;">
                            <button class="btn btn-outline-secondary w-100" onclick="document.getElementById('bgImageUpload').click()">
                                <i class="fas fa-image"></i> 选择图片
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-section" id="qrcodePanel" style="display: none;">
                    <h3 class="panel-title">二维码生成</h3>
                    <ul class="nav nav-tabs mb-3" id="qrTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="qr-url-tab" type="button">网址</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="qr-text-tab" type="button">文字</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="qr-card-tab" type="button">名片</button>
            </li>
        </ul>
        <div class="tab-content" id="qrTabContent">
            <div class="tab-pane show active" id="qr-url" role="tabpanel">
                <div class="form-group">
                    <label>输入网址</label>
                    <input type="url" id="qrUrlInput" class="form-control" placeholder="https://example.com">
                </div>
            </div>
            <div class="tab-pane" id="qr-text" role="tabpanel" style="display:none">
                <div class="form-group">
                    <label>输入文字</label>
                    <textarea id="qrTextInput" class="form-control" rows="3" placeholder="输入任意文字..."></textarea>
                </div>
            </div>
            <div class="tab-pane" id="qr-card" role="tabpanel" style="display:none">
                <div class="form-group">
                    <label>姓名</label>
                    <input type="text" id="qrCardName" class="form-control" placeholder="您的姓名">
                </div>
                <div class="form-group">
                    <label>电话</label>
                    <input type="tel" id="qrCardPhone" class="form-control" placeholder="联系电话">
                </div>
                <div class="form-group">
                    <label>邮箱</label>
                    <input type="email" id="qrCardEmail" class="form-control" placeholder="电子邮箱">
                </div>
            </div>
        </div>
                    <button class="btn btn-primary w-100" id="btnGenerateQR">
                        <i class="fas fa-qrcode"></i> 生成二维码
                    </button>
                </div>

                <div class="panel-section" id="templatePanel" style="display: none;">
                    <h3 class="panel-title">选择模板</h3>
                    @foreach(collect($templates)->groupBy('category_name') as $category => $categoryTemplates)
                        <div class="template-category">
                            <h4 class="template-category-title">{{ $category }}</h4>
                            <div class="template-grid">
                                @foreach($categoryTemplates as $template)
                                    <div class="template-item" data-template="{{ $template['id'] }}"
                                         data-width="{{ $template['width'] }}"
                                         data-height="{{ $template['height'] }}"
                                         data-bg="{{ $template['background'] }}"
                                         data-svg="{{ base64_encode($template['svg']) }}">
                                        <div class="template-preview">{!! $template['svg'] !!}</div>
                                        <span>{{ $template['name'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="panel-section" id="layersPanel" style="display: none;">
                    <h3 class="panel-title">图层</h3>
                    <div class="layers-list" id="layersList">
                        <p class="text-muted" id="layersPlaceholder">暂无元素</p>
                    </div>
                </div>
                <div class="panel-section" id="objectPanel" style="display: none;">
                    <h3 class="panel-title">对象设置</h3>
                    <div class="form-group">
                        <label>不透明度</label>
                        <input type="range" id="objOpacity" min="0" max="100" value="100">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-secondary w-100" id="btnLock">
                            <i class="fas fa-lock-open"></i> <span id="lockText">锁定</span>
                        </button>
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
                <div class="toolbar-divider"></div>
                <button class="toolbar-btn" id="btnAlignLeft" title="左对齐">
                    <i class="fas fa-align-left"></i>
                </button>
                <button class="toolbar-btn" id="btnAlignCenter" title="水平居中">
                    <i class="fas fa-align-center"></i>
                </button>
                <button class="toolbar-btn" id="btnAlignRight" title="右对齐">
                    <i class="fas fa-align-right"></i>
                </button>
                <button class="toolbar-btn" id="btnAlignTop" title="顶部对齐">
                    <i class="fas fa-arrow-up"></i>
                </button>
                <button class="toolbar-btn" id="btnAlignMiddle" title="垂直居中">
                    <i class="fas fa-arrows-alt-v"></i>
                </button>
                <button class="toolbar-btn" id="btnAlignBottom" title="底部对齐">
                    <i class="fas fa-arrow-down"></i>
                </button>
                <div class="toolbar-divider"></div>
                <button class="toolbar-btn" id="btnDistributeH" title="水平分布">
                    <i class="fas fa-arrows-alt-h"></i>
                </button>
                <button class="toolbar-btn" id="btnDistributeV" title="垂直分布">
                    <i class="fas fa-arrows-alt-v"></i>
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

    <div id="qrcode" style="display: none;"></div>
    <input type="hidden" id="productId" value="{{ $productId ?? '' }}">
    <script src="{{ asset('js/designer.js') }}?v={{ filemtime(public_path('js/designer.js')) }}"></script>
</body>
</html>
