"use strict";
var el, fontSize, index, style, setData, newData;
let elementToShow = document.getElementById("textChild"); 
let fontSizeFiled = document.getElementById("font-size");
let generatedText = document.getElementById("sample-text");
let attribName = document.getElementById("attrib-name");
let attribType = document.getElementById("attrib-type");
let certificateImg = document.getElementById("certificate-img");
let fontRatio = (certificateImg.offsetWidth/certificateImg.naturalWidth + certificateImg.offsetHeight/certificateImg.naturalHeight)/2;

// If template have attributes already
if($(".scrollInput")[0]){
    for (let i=0; i<$(".scrollInput").length; i++){
        let div = document.createElement('div');  
        div.className = 'scrollText';
        let divText = document.createElement('div');  
        divText.className = 'scrollTextContent';
        divText.innerHTML = JSON.parse($(".scrollInput")[i].value).attribSample;
        div.setAttribute("data-id", i);
        div.setAttribute('onclick', "showAttribs("+i.toString()+")");
        div.style.fontSize = (fontRatio*(JSON.parse($(".scrollInput")[i].value).fontSize)) + 'px';
        document.getElementById("textParent").appendChild(div);
        div.appendChild(divText);

        let prevImgHeight = parseFloat(JSON.parse(document.getElementsByName("imageSize")[0].getAttribute("value"))["imgHeight"]);
        let prevImgWidth = parseFloat(JSON.parse(document.getElementsByName("imageSize")[0].getAttribute("value"))["imgWidth"]);
        let calculatedTop = (parseFloat(JSON.parse($(".scrollInput")[i].value).yPosition)*certificateImg.offsetHeight)/prevImgHeight; 
        let calculatedLeft = (parseFloat(JSON.parse($(".scrollInput")[i].value).xPosition)*certificateImg.offsetWidth)/prevImgWidth;         
        div.style.top=certificateImg.offsetTop+ calculatedTop -(div.offsetHeight/2)+"px";
        div.style.left=certificateImg.offsetLeft+ calculatedLeft -(div.offsetWidth/2)+"px";
    }
}

reloadDrag();

// Function for adding texts
var elementCount = elementCount || $(".scrollText")[0] ? $(".scrollText").length-1 : -1;
function addTexts() {
    // this.preventDefault();
    elementCount=elementCount+1;
    let div = document.createElement('div');  
    div.className = 'scrollText';
    let divText = document.createElement('div');  
    divText.className = 'scrollTextContent';
    divText.innerHTML = `Sample Text `+(elementCount+1);
    divText.style.fontSize = (fontRatio*200) + 'px';
    div.setAttribute("data-id", elementCount);
    div.setAttribute('onclick', "showAttribs("+elementCount.toString()+")");
    div.style.top= 250+20*(elementCount)+"px";
    div.style.left=200+20*(elementCount)+"px";
    let initailX = 250+20*(elementCount)+(div.offsetWidth/2);
    let initailY = 200+20*(elementCount)+(div.offsetHeight/2);
    document.getElementById("textParent").appendChild(div);
    div.appendChild(divText);
    let input = document.createElement('input');
    input.className = 'scrollInput';
    input.setAttribute("type", "hidden");
    input.setAttribute("data-id", elementCount);
    input.setAttribute("name", "attribute-"+(elementCount+1));
    let dataToBeSetted = '{"attribType":"static", "attribName":"attribute-'+(elementCount+1)+'", "attribSample":"Sample Text '+(elementCount+1)+'", "fontSize":"200", "xPosition":"'+initailX+'px", "yPosition":"'+initailY+'px"}';
    input.setAttribute("value", dataToBeSetted);
    document.getElementById("textParent").appendChild(input); 
    reloadDrag();
    showTextBorder(div);
    setImageSize();
}

// Embade attributes with fucntional btns and the selected text
function showAttribs(id){
    removeTextBorders($(".scrollText")[id]);
    showTextBorder($(".scrollText")[id]);
    let selectedText = window.getComputedStyle($(".scrollTextContent")[id], null);
    elementToShow.style.display="flex";
    elementToShow.setAttribute("data-id", id);
    index = id;
    generatedText.value=$(".scrollTextContent")[id].innerHTML;
    fontSizeFiled.value = Math.round(parseFloat(selectedText.getPropertyValue('font-size'))/fontRatio);
    setData = $(".scrollInput")[id];
    attribName.value=setData.getAttribute("name");
    newData = JSON.parse(setData.value);
    Object.assign(newData).fontSize=fontSizeFiled.value;
    if(Object.assign(newData).attribType=='static')
        attribType.options[0].selected = true;
    else
        attribType.options[1].selected = true;
    Object.assign(newData).attribSample=generatedText.value;
    Object.assign(newData).attribName=attribName.value;
    setData.value = JSON.stringify(newData);
}

// Functions for increment and decrement of font size
function increaseSize(){
    el = $(".scrollTextContent")[index];
    fontSizeFiled.value = parseFloat(fontSizeFiled.value) + 1;
    el.style.fontSize = (fontRatio*fontSizeFiled.value) + 'px';
    setFontData(fontSizeFiled.value);
}
function decreaseSize(){
    el = $(".scrollTextContent")[index];
    fontSizeFiled.value = parseFloat(fontSizeFiled.value) - 1;
    el.style.fontSize = (fontRatio*fontSizeFiled.value) + 'px';
    setFontData(fontSizeFiled.value);
}
// Change font by direct typing in input box
function changeFontSize(){
    el = $(".scrollTextContent")[index];
    fontSize = fontSizeFiled.value;
    el.style.fontSize = (fontRatio*fontSize) + 'px';
    setFontData(fontSize);
}
// Set font points in the data that will be gonna send
function setFontData(fontPoints){
    newData = JSON.parse(setData.value);
    Object.assign(newData).fontSize=fontPoints;
    setData.value = JSON.stringify(newData);
    setImageSize();
}
// Change inner HTML
function sampleText(){
    el = $(".scrollTextContent")[index];
    el.innerHTML = generatedText.value;
    newData = JSON.parse(setData.value);
    Object.assign(newData).attribSample=generatedText.value;
    setData.value = JSON.stringify(newData);
    setImageSize();
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
            let elmnt=$(".scrollText")[i];
            dragElement(elmnt);
            removeTextBorders(elmnt);
        }
    }
}
// Show box around slected text
function showTextBorder(elmnt){
    let corenr1 = document.createElement('div');  
    let corenr2 = document.createElement('div');  
    let corenr3 = document.createElement('div');  
    let corenr4 = document.createElement('div');  
    corenr1.classList.add("text-corners", "text-corner-top-left");
    corenr2.classList.add("text-corners", "text-corner-top-right");
    corenr3.classList.add("text-corners", "text-corner-bottom-left");
    corenr4.classList.add("text-corners", "text-corner-bottom-right");
    elmnt.append(corenr1, corenr2, corenr3, corenr4); 
    elmnt.classList.add("scrollTextSelected");
}
// Remove all the boxes from selected texts
function removeTextBorders(elmnt){
    document.querySelectorAll('.scrollTextSelected').forEach(elmnt => elmnt.classList.remove("scrollTextSelected"));
    document.querySelectorAll('.text-corners').forEach(elmnt => elmnt.remove());
}
// Drag single element
function dragElement(elmnt) {
    showTextBorder(elmnt);
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    showAttribs(elmnt.getAttribute("data-id"));
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onpointerdown = dragMouseDown;

    function dragMouseDown(e) {     
        e = e || window.event;
        // e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onpointerup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onpointermove = elementDrag;
    }

    function elementDrag(e) {
        e = e || window.event;
        // e.preventDefault();
        elmnt.style.cursor = "grabbing";
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        index = elementToShow.getAttribute("data-id");
        setData = $(".scrollInput")[index];
        newData = JSON.parse(setData.value);
        Object.assign(newData).xPosition=((elmnt.offsetLeft - pos1)-certificateImg.offsetLeft+(elmnt.offsetWidth/2))+"px";
        Object.assign(newData).yPosition=((elmnt.offsetTop - pos2)-certificateImg.offsetTop+(elmnt.offsetHeight/2))+"px";
        setData.value = JSON.stringify(newData);
        setImageSize()
    }

    function closeDragElement() {
        /* stop moving when mouse button is released:*/
        elmnt.style.cursor = "grab";
        document.onpointerup = null;
        document.onpointermove = null;
    }
}
// Sent image size to databse or reload it after any alteration
function setImageSize(){
    if(!(document.getElementsByName("imageSize")[0])){
        let imgData = document.createElement('input');
        imgData.setAttribute("type", "hidden");
        imgData.setAttribute("name", "imageSize");
        let dataToBeSetted = '{"imgWidth":'+certificateImg.offsetWidth+', "imgHeight":'+certificateImg.offsetHeight+'}';
        imgData.setAttribute("value", dataToBeSetted);
        document.getElementById("textParent").appendChild(imgData);
    }
    else if(document.getElementsByName("imageSize")[0]){        
        let dataToBeSetted = '{"imgWidth":'+certificateImg.offsetWidth+', "imgHeight":'+certificateImg.offsetHeight+'}';
        document.getElementsByName("imageSize")[0].setAttribute("value", dataToBeSetted);
    }
}