import React, { useState, useEffect } from 'react';
import { DesignerCanvas } from './components/DesignerCanvas';
import { Toolbar } from './components/Toolbar';
import { TextPanel } from './components/TextPanel';
import { ShapePanel } from './components/ShapePanel';
import { ImagePanel } from './components/ImagePanel';
import { useDesignerStore } from './store/useDesignerStore';

export const Designer = ({ productImage, productName, productPrice }) => {
  const [activePanel, setActivePanel] = useState('text');
  const { setProductInfo, exportDesign } = useDesignerStore();

  useEffect(() => {
    if (productName && productPrice) {
      setProductInfo(productName, productPrice, productImage);
    }
  }, [productName, productPrice, productImage]);

  const handleExport = () => {
    const dataUrl = exportDesign();
    if (dataUrl) {
      const link = document.createElement('a');
      link.download = `${productName || 'design'}-${Date.now()}.png`;
      link.href = dataUrl;
      link.click();
    }
  };

  const handleAddToCart = () => {
    const dataUrl = exportDesign();
    if (dataUrl) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/cart/add';

      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

      const productIdInput = document.createElement('input');
      productIdInput.type = 'hidden';
      productIdInput.name = 'product_id';
      productIdInput.value = window.designerProductId || '';
      form.appendChild(productIdInput);

      const designInput = document.createElement('input');
      designInput.type = 'hidden';
      designInput.name = 'custom_design';
      designInput.value = dataUrl;
      form.appendChild(designInput);

      if (csrfToken) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);
      }

      document.body.appendChild(form);
      form.submit();
    }
  };

  const panels = {
    text: <TextPanel />,
    shape: <ShapePanel />,
    image: <ImagePanel />
  };

  return (
    <div className="designer-container">
      <div className="designer-header">
        <h2>在线设计器 - {productName || '自定义产品'}</h2>
        <div className="header-actions">
          <button className="btn-secondary" onClick={handleExport}>
            <i className="fas fa-download"></i> 导出设计
          </button>
          <button className="btn-primary" onClick={handleAddToCart}>
            <i className="fas fa-shopping-cart"></i> 加入购物车 ${productPrice || 0}
          </button>
        </div>
      </div>

      <div className="designer-workspace">
        <div className="designer-left-panel">
          <Toolbar />
        </div>

        <div className="designer-canvas-area">
          <DesignerCanvas
            productImage={productImage}
            canvasWidth={600}
            canvasHeight={600}
          />
        </div>

        <div className="designer-right-panel">
          <div className="panel-tabs">
            <button
              className={`tab-btn ${activePanel === 'text' ? 'active' : ''}`}
              onClick={() => setActivePanel('text')}
            >
              文本
            </button>
            <button
              className={`tab-btn ${activePanel === 'shape' ? 'active' : ''}`}
              onClick={() => setActivePanel('shape')}
            >
              形状
            </button>
            <button
              className={`tab-btn ${activePanel === 'image' ? 'active' : ''}`}
              onClick={() => setActivePanel('image')}
            >
              图片
            </button>
          </div>

          <div className="panel-content">
            {panels[activePanel]}
          </div>
        </div>
      </div>
    </div>
  );
};
