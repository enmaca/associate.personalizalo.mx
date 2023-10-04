import Konva from "konva";

const loadImg = (url) => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => resolve(img);
    img.onerror = reject;
    img.src = url;
  });
};

let sceneWidth = 0;
let sceneHeight = 0;

const stage = new Konva.Stage({
  container: "customizator",
});

const staticLayer = new Konva.Layer();
stage.add(staticLayer);

const setBackground = (url) => {
  loadImg(url).then((img) => {
    sceneWidth = img.naturalWidth;
    sceneHeight = img.naturalHeight;

    stage.width(sceneWidth);
    stage.height(sceneHeight);

    const bg = new Konva.Image({
      x: 0,
      y: 0,
      image: img,
      width: sceneWidth,
      height: sceneHeight,
      listening: false,
    });
    staticLayer.add(bg);

    fitStageIntoParentContainer();
  });
};

document.querySelector("#bgSelector").addEventListener("change", (e) => {
  const file = e.target.files[0];
  const reader = new FileReader();
  reader.onload = (ev) => {
    setBackground(ev.target.result);
  };
  reader.readAsDataURL(file);
});

setBackground(
  "https://loremflickr.com/cache/resized/65535_52945682677_568fc25818_c_600_800_nofilter.jpg"
);

const fitStageIntoParentContainer = () => {
  var container = document.querySelector("#customizator");

  // now we need to fit stage into parent container
  var containerWidth = container.offsetWidth;

  // but we also make the full scene visible
  // so we need to scale all objects on canvas
  var scale = containerWidth / sceneWidth;

  stage.width(sceneWidth * scale);
  stage.height(sceneHeight * scale);
  stage.scale({ x: scale, y: scale });
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

const selectorLayer = new Konva.Layer();
stage.add(selectorLayer);

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

const mainLayer = new Konva.Layer();
stage.add(mainLayer);

stage.on("mouseup touchend", (e) => {
  // do nothing if we didn't start selection
  if (!selectionRectangle.visible()) {
    return;
  }
  e.evt.preventDefault();
  // update visibility in timeout, so we can check it in click event
  setTimeout(() => {
    const generatedRect = new Konva.Rect({
      x: selectionRectangle.x(),
      y: selectionRectangle.y(),
      width: selectionRectangle.width(),
      height: selectionRectangle.height(),
      stroke: "red",
      strokeWidth: 1,
      dash: [10, 5],
    });

    mainLayer.add(generatedRect);

    selectionRectangle.visible(false);
  });
});
