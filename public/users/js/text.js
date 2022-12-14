"use strict";
var el, fontSize, index, style, setData, newData;
let elementToShow = document.getElementById("textChild"); 
let fontSizeFiled = document.getElementById("font-size");
let generatedText = document.getElementById("sample-text");
let attribName = document.getElementById("attrib-name");
let attribType = document.getElementById("attrib-type");
let certificateImg = document.getElementById("certificate-img");
let imgData = document.createElement('input');
imgData.setAttribute("type", "hidden");
imgData.setAttribute("name", "imageSize");
let dataToBeSetted = '{"imgWidth":'+certificateImg.offsetWidth+', "imgHeight":'+certificateImg.offsetHeight+'}';
imgData.setAttribute("value", dataToBeSetted);
document.getElementById("textParent").appendChild(imgData);  
reloadDrag();

var elementCount = elementCount || -1;
function addTexts() {
    // this.preventDefault();
    elementCount=elementCount+1;
    let div = document.createElement('div');  
    div.className = 'scrollText';
    div.innerHTML = `Sample Text `+(elementCount+1);
    div.setAttribute("data-id", elementCount);
    div.setAttribute('onclick', "showAttribs("+elementCount.toString()+")");
    document.getElementById("textParent").appendChild(div);
    let input = document.createElement('input');
    input.className = 'scrollInput';
    input.setAttribute("type", "hidden");
    input.setAttribute("data-id", elementCount);
    input.setAttribute("name", "attribute-"+(elementCount+1));
    let dataToBeSetted = '{"attribType":"static", "attribName":"", "attribSample":"","fontSize":""}';
    input.setAttribute("value", dataToBeSetted);
    document.getElementById("textParent").appendChild(input);    
    reloadDrag();
}

// Embade attributes with fucntional btns and the selected text
function showAttribs(id){
    let selectedText = window.getComputedStyle($(".scrollText")[id], null);
    elementToShow.style.display="flex";
    elementToShow.setAttribute("data-id", id);
    index = id;
    generatedText.value=$(".scrollText")[id].innerHTML;
    fontSizeFiled.value = parseFloat(selectedText.getPropertyValue('font-size'));
    setData = $(".scrollInput")[id];
    attribName.value=setData.getAttribute("name");
    newData = JSON.parse(setData.value);
    Object.assign(newData).fontSize=selectedText.getPropertyValue('font-size');
    if(Object.assign(newData).attribType=='static')
        attribType.options[0].selected = true;
    else
        attribType.options[1].selected = true;
    Object.assign(newData).attribSample=generatedText.value;
    Object.assign(newData).attribName=attribName.value;
    setData.value = JSON.stringify(newData);
}

// Functions for increment and decrement of font size
function fontSizeOpreations(){
    el = $(".scrollText")[index];
    style = window.getComputedStyle(el, null).getPropertyValue('font-size');
    fontSize = parseFloat(style); 
}
function increaseSize(){
    fontSizeOpreations();
    el.style.fontSize = (fontSize + 1) + 'px';
    fontSizeFiled.value = fontSize + 1;
    setFontData()
}
function decreaseSize(){
    fontSizeOpreations();
    if(fontSize>0){
        el.style.fontSize = (fontSize - 1) + 'px';
        fontSizeFiled.value = fontSize - 1;
        setFontData()
    }
}
function changeFontSize(){
    fontSize = fontSizeFiled.value;
    el = $(".scrollText")[index];
    el.style.fontSize = fontSize + 'px';
    setFontData()
}
function setFontData(){
    newData = JSON.parse(setData.value);
    Object.assign(newData).fontSize=el.style.fontSize;
    setData.value = JSON.stringify(newData);
}
// Change inner HTML
function sampleText(){
    el = $(".scrollText")[index];
    el.innerHTML = generatedText.value;
    newData = JSON.parse(setData.value);
    Object.assign(newData).attribSample=generatedText.value;
    setData.value = JSON.stringify(newData);
}
// Change attrib name
function changeAttribName(){
    setData.setAttribute("name", attribName.value)
    newData = JSON.parse(setData.value);
    Object.assign(newData).attribName=attribName.value;
    setData.value = JSON.stringify(newData);
}
// Change Attribute Type
function changeAttribType(){
    newData = JSON.parse(setData.value);
    Object.assign(newData).attribType=attribType.value;
    setData.value = JSON.stringify(newData);
}
// Make drag for multiple elements
function reloadDrag(){
    if($(".scrollText")){
        for (let i=0; i<$(".scrollText").length; i++){
            dragElement($(".scrollText")[i]);
        }
    }
}

// Drag single element
function dragElement(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    showAttribs(elmnt.getAttribute("data-id"));
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;

    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        elmnt.style.cursor = "grabbing";
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        // console.log(certificateImg.offsetLeft-(elmnt.offsetLeft - pos1)+(elmnt.offsetWidth/2), certificateImg.offsetTop-(elmnt.offsetTop - pos2)+(elmnt.offsetHeight/2));
        index = elementToShow.getAttribute("data-id");
        setData = $(".scrollInput")[index];
        newData = JSON.parse(setData.value);
        // Object.assign(newData).xPosition=((elmnt.offsetLeft - pos1)-certificateImg.offsetLeft+(elmnt.offsetWidth/2))+"px";
        // Object.assign(newData).yPosition=((elmnt.offsetTop - pos2)-certificateImg.offsetTop+(elmnt.offsetHeight/2))+"px";
        Object.assign(newData).xPosition=((elmnt.offsetLeft - pos1)-certificateImg.offsetLeft+(elmnt.offsetWidth/2))+"px";
        Object.assign(newData).yPosition=((elmnt.offsetTop - pos2)-certificateImg.offsetTop+(elmnt.offsetHeight/2))+"px";
        setData.value = JSON.stringify(newData);
    }

    function closeDragElement() {
        /* stop moving when mouse button is released:*/
        elmnt.style.cursor = "grab";
        document.onmouseup = null;
        document.onmousemove = null;
    }
}