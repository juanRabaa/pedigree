
function getRandomColorFull() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	
    return result ? "rgb("+ parseInt(result[1], 16) +","+ parseInt(result[2], 16) +","+ parseInt(result[3], 16) +")" : null;
}

function addAlphaToRGB ( rgb, alpha = Math.random() ){//rgb has to be rgb(x, y, z)
	return rgb.replace(" ", "").replace("rgb","rgba").replace(")", "," + alpha +")");
}

function getRandomColorRGB (){
	return ("rgb("+ between(0, 255) + "," + between(0, 255) + "," + between(0, 255) + ")");
}

function getRandomColorRGBA( randomAlpha = false ){
  var alpha = 1
  if ( randomAlpha )
	alpha = Math.random();
	
  return ("rgba("+ between(0, 255) + "," + between(0, 255) + "," + between(0, 255) + "," + alpha + ")");
}

function between (x, y, except = []){
	do {
		var randomBetween = Math.floor( Math.random() * (y - x) + x );
	}while ( except.includes(randomBetween) )
	return randomBetween;
}
