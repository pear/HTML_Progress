var isDom = document.getElementById?true:false;
var isIE  = document.all?true:false;
var isNS4 = document.layers?true:false;
var cellCount = 10;

function setprogress(pIdent, pValue, pString, pDeterminate)
{
    if (isDom) {
        prog = document.getElementById(pIdent+'installationProgress');
    } else if (isIE) {
        prog = document.all[pIdent+'installationProgress'];
    } else if (isNS4) {
        prog = document.layers[pIdent+'installationProgress'];
    }
    if (prog != null) {
        prog.innerHTML = pString;
    }
    if (pValue == pDeterminate) {
        for (i=0; i < cellCount; i++) {
            showCell(i, pIdent, "hidden");	
        }
    }
    if ((pDeterminate > 0) && (pValue > 0)) {
        i = (pValue-1) % cellCount;
        showCell(i, pIdent, "visible");	
    } else {
        for (i=pValue-1; i >=0; i--) {
            showCell(i, pIdent, "visible");	
            if (isDom)
                document.getElementById(pIdent+'progressCell'+i+'A').innerHTML = i;
            if (isIE)
                document.all[pIdent+'progressCell'+i+'A'].innerHTML = i;
            if (isNS4)
                document.layers[pIdent+'progressCell'+i+'A'].innerHTML = i;
        }
    }
}

function setVisibility(pElement, pVisibility)
{
    if (isDom) {
        document.getElementById(pElement).style.visibility = pVisibility;
    } else if (isIE) {
        document.all[pElement].style.visibility = pVisibility;
    } else if (isNS4) {
        document.layers[pElement].style.visibility = pVisibility;
    }
}

function showCell(pCell, pIdent, pVisibility)
{
    setVisibility(pIdent+'progressCell'+pCell+'A', pVisibility);
}
