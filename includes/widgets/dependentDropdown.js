var vg = new Array();
function sg(oldHandler,newHandler) {
var ou = function () {
newHandler();
if (oldHandler) {
oldHandler();
}
}
return ou;
}
window.onload = sg(window.onload,Jo);

function initMenu(Pn, jt) {
var Cf = document.getElementById(Pn);
Cf.jt = jt;
vg[Pn] = 1;
}
function oB(Pn, defaultValue, jt) {
var xx;
var Cf = document.getElementById(Pn);
var bM = document.getElementById(jt);
var GC = eval('dddefaults_' + Pn);
var QT = eval('ddfks_' + Pn);
var fF = eval('ddnames_' + Pn);


if (!QT) {
return;
}

var QF = null;
if (document.createElement) {
QF = document.createElement('div');
if (QF.innerText != "") {
QF = null;
}
}


if (defaultValue) {

for (xx=0;xx<Cf.options.length;xx++) {
if (Cf.options[xx].value == defaultValue) {
Cf.selectedIndex = xx;
return;
}
}

while(Cf.options.length) {
Cf.options[0] = null;
}


var qE = QT[defaultValue];
if (!qE) {

return;
}


for(xx in GC) {
if (QF) {
QF.innerHTML = GC[xx];
var LM = new Option(QF.innerText, xx);
} else {
var LM = new Option(GC[xx], xx);
}
Cf.options[Cf.options.length]=LM;
}


for(xx in QT) {
if (QT[xx] == qE) {
if (QF) {
QF.innerHTML = fF[xx];
var LM = new Option(QF.innerText, xx);
} else {
var LM = new Option(fF[xx], xx);
}
Cf.options[Cf.options.length]=LM;
if (defaultValue == xx) {
Cf.selectedIndex = Cf.options.length-1;
}
}
}


var hM = bM.jt;
if(hM) {

oB(jt, qE, hM);
} else {

for (xx=0;xx<bM.options.length;xx++) {
if (bM.options[xx].value == qE) {
bM.selectedIndex = xx;
return;
}
}
}
} else {
if (bM.options.length > 0) {
if (bM.selectedIndex == -1) {
bM.selectedIndex = 0;
}
qE = bM.options[bM.selectedIndex].value;

while(Cf.options.length) {
Cf.options[0] = null;
}

for(xx in GC) {
if (QF) {
QF.innerHTML = GC[xx];
var LM = new Option(QF.innerText, xx);
} else {
var LM = new Option(GC[xx], xx);
}
Cf.options[Cf.options.length]=LM;
}


for(xx in QT) {
if (QT[xx] == qE) {
if (QF) {
QF.innerHTML = fF[xx];
var LM = new Option(QF.innerText, xx);
} else {
var LM = new Option(fF[xx], xx);
}
Cf.options[Cf.options.length]=LM;
if (defaultValue == xx) {
Cf.selectedIndex = Cf.options.length-1;
}
}
}
}
}
}
function PB() {
var jt = this.name;
var bM = document.getElementById(jt);
var xx;

var QF = null;
if (document.createElement) {
QF = document.createElement('div');
if (QF.innerText != "") {
QF = null;
}
}
for (xx in this.Pn) {
var Pn = this.Pn[xx];

var Cf = document.getElementById(Pn);

var GC = eval('dddefaults_' + Pn);
var QT = eval('ddfks_' + Pn);
var fF = eval('ddnames_' + Pn);

if (Cf.options.length != 0) {
var GO =Cf[Cf.options.length-1].value;
GO = QT[GO];
if (bM.selectedIndex != -1 && GO == bM.options[bM.selectedIndex].value) {
return;
}
}

while(Cf.options.length) {
Cf.options[0] = null;
}

if(bM.options.length == 0) {

continue;
}


for(xx in GC) {
if (QF) {
QF.innerHTML = GC[xx];
var LM = new Option(QF.innerText, xx);
} else {
var LM = new Option(GC[xx], xx);
}
Cf.options[Cf.options.length]=LM;
}


for(xx in QT) {
if (QT[xx] == bM.options[bM.selectedIndex].value) {
if (QF) {
QF.innerHTML = fF[xx];
var LM = new Option(QF.innerText, xx);
} else {
var LM = new Option(fF[xx], xx);
}
Cf.options[Cf.options.length]=LM;
}
}

if (Cf.onchange) {

Cf.onchange();
} else if (Cf.fireEvent) {

Cf.fireEvent('onchange');
} else {
var event = document.createEvent("MouseEvents");
event.initMouseEvent("mouseup", 1, 1, window, 1, 10, 50, 10, 50, 0, 0, 0, 0, 1, Cf);
Cf.dispatchEvent(event);
}
}
}
function sa() {
for(xx in vg) {
if(vg[xx] == 1) {
return xx;
}
}
return false;
}
function Jo() {

var OH = new Array();
var ei = new Array();
for (xx in vg) {
ei[xx] = vg[xx];
}
for(xx in ei) {

var Np = document.getElementById(xx);
var jt = Np.jt;
sn(xx, jt);

var si = eval('dddefval_' + xx);
if(si) {
OH[xx] = si;

var mM = document.getElementById(xx);
while(mM.jt) {
vg[mM.jt] = 0;
mM = document.getElementById(mM.jt);
}
}
}


for(xx in OH) {
if(vg[xx] == 1) {
var ra = document.getElementById(xx);
vg[xx] = 0;
oB(xx, OH[xx], ra.jt);
}
}


var tq = sa();
while(tq) {

var mM = document.getElementById(tq);
while(mM.jt) {
mM = document.getElementById(mM.jt);
}

Xj(mM);
tq = sa();
}
}
function Xj(parentO) {
for (xx in parentO.Pn) {
Pn = parentO.Pn[xx];
var Cf = document.getElementById(Pn);
if(vg[Pn] == 1) {
oB(Pn, "", parentO.id);
vg[Pn] = 0;
}
Xj(Cf);
}
}
function sn(Pn, jt) {
document.getElementById(jt).onchange = PB;
document.getElementById(jt).onkeyup = PB;
document.getElementById(jt).onmouseup = PB;

var bM = document.getElementById(jt);
if (!bM.Pn){
bM.Pn = new Array();
}
bM.Pn[bM.Pn.length] = Pn;

}
