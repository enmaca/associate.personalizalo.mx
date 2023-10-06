import Alpine from "alpinejs";
import Konva from "konva";

Alpine.store("customizationData", {
  selected: null,
  items: [],

  setItems(items) {
    this.items.splice(0, this.items.length, ...items);
  },

  setSelected(value) {
    document.querySelector('#modeSelect').checked = true;
    this.selected = value;
    tr.nodes(value === null ? [] : [mainLayer.findOne(`#${value}`)]);
  },

  remove(itemId) {
    const index = this.items.findIndex((item) => item.id === itemId);

    if (index === -1) {
      return;
    }
    this.items.splice(index, 1);
    customizationData.remove(index);
  },
});

Alpine.start();

let sceneWidth = 0;
let sceneHeight = 0;

const stage = new Konva.Stage({
  container: "customizator",
});

document.querySelector("#bgSelector").addEventListener("change", (e) => {
  const file = e.target.files[0];
  const reader = new FileReader();
  reader.onload = (ev) => {
    // setBackground(ev.target.result);
  };
  reader.readAsDataURL(file);
});

const hasScroll = () => document.body.scrollHeight > document.body.clientHeight;

let oldhasScroll = hasScroll();

const fitStageIntoParentContainer = () => {
  const container = document.querySelector("#customizator");

  // now we need to fit stage into parent container
  const containerWidth = container.offsetWidth;

  // but we also make the full scene visible
  // so we need to scale all objects on canvas
  const scale = containerWidth / sceneWidth;

  stage.width(sceneWidth * scale);
  stage.height(sceneHeight * scale);
  stage.scale({ x: scale, y: scale });

  if (oldhasScroll !== hasScroll()) {
    oldhasScroll = hasScroll();
    fitStageIntoParentContainer();
  }
};

let debounceTimeout;

window.addEventListener("resize", () => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    fitStageIntoParentContainer();
  }, 100);
});

const getToolMode = () => {
  return document.querySelector('input[name="tool-mode"]:checked').value;
};

const mainLayer = new Konva.Layer();
stage.add(mainLayer);

const selectorLayer = new Konva.Layer();
stage.add(selectorLayer);

const tr = new Konva.Transformer({
  ignoreStroke: true,
  anchorStroke: "rgba(0,0,255,1)",
  anchorFill: "rgba(0,0,255,0.5)",
  anchorStyleFunc: (anchor) => {
    anchor.cornerRadius(10);
  },
});
selectorLayer.add(tr);

const selectionRectangle = new Konva.Rect({
  fill: "rgba(0,0,255,0.5)",
  visible: false,
});

selectorLayer.add(selectionRectangle);

var x1, y1, x2, y2;
stage.on("mousedown touchstart", (e) => {
  e.evt.preventDefault();

  if (getToolMode() === "add") {
    x1 = stage.getPointerPosition().x / stage.scaleX();
    y1 = stage.getPointerPosition().y / stage.scaleY();
    x2 = stage.getPointerPosition().x / stage.scaleX();
    y2 = stage.getPointerPosition().y / stage.scaleY();

    selectionRectangle.visible(true);
    selectionRectangle.width(0);
    selectionRectangle.height(0);
  }
});

stage.on("mousemove touchmove", (e) => {
  // do nothing if we didn't start selection
  if (!selectionRectangle.visible()) {
    return;
  }

  e.evt.preventDefault();
  x2 = stage.getPointerPosition().x / stage.scaleX();
  y2 = stage.getPointerPosition().y / stage.scaleY();

  selectionRectangle.setAttrs({
    x: Math.min(x1, x2),
    y: Math.min(y1, y2),
    width: Math.abs(x2 - x1),
    height: Math.abs(y2 - y1),
  });
});

stage.on("mouseup touchend", (e) => {
  // do nothing if we didn't start selection
  if (!selectionRectangle.visible()) {
    return;
  }
  e.evt.preventDefault();
  // update visibility in timeout, so we can check it in click event
  setTimeout(() => {
    const thW = stage.width() / 100 * 5;
    const thH = stage.height() / 100 * 5;

    const newRect = {
      type: "rect",
      x: selectionRectangle.x(),
      y: selectionRectangle.y(),
      width: selectionRectangle.width(),
      height: selectionRectangle.height(),
      stroke: "red",
      strokeWidth: 1,
      dash: [10, 5],
      strokeScaleEnabled: false,
    };

    if (newRect.width === 0 && newRect.height === 0) {
      document.querySelector('#modeSelect').checked = true;
    } else if (newRect.width > thW && newRect.height > thH) {
      customizationData.add(newRect);
    } else {
      setTimeout(() => {
        alert('too small, adjust the threshold');
      }, 200);
    }

    selectionRectangle.visible(false);
  });
});

stage.on("click tap", function (e) {
  Alpine.store("customizationData").setSelected(null);

  if (tr.nodes()?.[0]) {
    tr.nodes()[0].draggable(false);
  }

  if (getToolMode() === "add") {
    return;
  }

  // if click on empty area - remove all selections
  if (e.target === stage) {
    tr.nodes([]);
    return;
  }

  if (!e.target.id()) {
    tr.nodes([]);
    return;
  }

  tr.nodes([e.target]);
  e.target.draggable(true);
  Alpine.store("customizationData").setSelected(e.target.id());
});

const transformHandler = (e) => {
  const node = e.target;
  const scaleX = node.scaleX();
  const scaleY = node.scaleY();

  // we will reset it back
  node.scaleX(1);
  node.scaleY(1);

  const width = node.width() * scaleX;
  const height = node.height() * scaleY;

  node.width(width);
  node.height(height);
};

const customizationData = {
  selected: null,
  items: [],
  async renderItem(item) {
    item.id = "item_" + (item.modelId || Date.now());
    if (item.type === "imageFromUrl") {
      return new Promise((resolve) => {
        Konva.Image.fromURL(item.src, (konvaObj) => {
          const img = konvaObj.image();

          const { naturalWidth, naturalHeight } = img;

          konvaObj.setAttrs({
            ...item,
            width: naturalWidth,
            height: naturalHeight,
          });

          konvaObj.on("transform", transformHandler);

          mainLayer.add(konvaObj);

          sceneWidth = naturalWidth;
          sceneHeight = naturalHeight;

          resolve();
        });
      });
    } else if (item.type === "rect") {
      const konvaObj = new Konva.Rect(item);

      konvaObj.on("transform", transformHandler);

      mainLayer.add(konvaObj);
    }
  },
  async render() {
    for (const item of this.items) {
      await this.renderItem(item);
    }
  },
  async set(items) {
    this.items = items;
    await this.render();

    Alpine.store("customizationData").setItems(this.items);

    fitStageIntoParentContainer();
  },
  add(item) {
    customizationData.items.push(item);
    this.renderItem(item);

    Alpine.store("customizationData").setItems(this.items);
  },
  remove(index) {
    customizationData.items.splice(index, 1);
    mainLayer.children[index].destroy();
    tr.nodes([]);
  },
  update(index, data) {
    customizationData.items[index] = data;
  },
  setSelected(value) {
    this.selected = value;
  },
};

customizationData.set([
  {
    modelId: 1,
    type: "imageFromUrl",
    x: 0,
    y: 0,
    src: "https://loremflickr.com/cache/resized/8032_29732634126_16ac267f9c_b_800_600_nofilter.jpg",
    width: 0,
    height: 0,
    listening: false,
  },
  {
    modelId: 2,
    height: 227.27272727272728,
    dash: [10, 5],
    stroke: "red",
    strokeWidth: 1,
    type: "rect",
    width: 245.4545454545454,
    x: 172.72727272727272,
    y: 136.93181818181816,
  },
]);
