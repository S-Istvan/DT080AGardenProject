var myTimer = window.setInterval(midLeftPicChange,10000);

var topDiv = document.getElementById("topDiv")
var midTopDiv = document.getElementById("midTopDiv")
var midBotDiv = document.getElementById("midBotDiv")
var botDiv = document.getElementById("botDiv")

TweenMax.staggerTo(["#topDiv", "#botDiv" ],1.5,{width: "90%", height: "25%",ease:Bounce.easeOut},0.5)
TweenMax.staggerTo(["#botDiv1", "#botDiv2", "#botDiv3", "#botDiv4","#botDiv5", "#botDiv6"],1.5,{top: "75%",delay:1.5,ease:Linear.easeNone},0.5)
TweenMax.staggerTo(["#midLeftDiv","#midMidDiv","#midRightDiv"], 1, {height:"50%",width:"30%", delay:1.5}, 0.5)
TweenMax.staggerTo(["#midLeftDiv","#midMidDiv","#midRightDiv"], 1, {transform:"rotateX(180deg", delay:1.5},0.5)
TweenMax.staggerTo(["#midLeftDiv","#midMidDiv","#midRightDiv"], 1, {transform:"rotateX(360deg", delay:3.5},0.5)
TweenMax.to(["#aboutTitle"],4,{opacity:"1", delay:1.5,transform:"rotateY(360deg)", ease:Bounce.easeOut})
TweenMax.to(["#aboutTitle"], 2, {text:{value:"Eden Project", delimiter:" "},delay:1, ease:Linear.easeNone});
TweenMax.staggerTo(["#groupInfoHead","#groupInfo","#courseInfo"],1,{opacity:"1",delay:3},0.5)


function midLeftPicChange()
{
   // TweenMax.to("#midLeftDiv",2,{width:"0%",height:"0%",transform:"rotateY(180deg)", onComplete:randomisePic});
    TweenMax.to("#randomPic",2,{opacity:"0",borderRadius:("360px"),transform:("scale(0) rotateY(180deg)"),onComplete:randomisePic})
}
function randomisePic()
{
    var rand = Math.floor(Math.random()*5);
    if (rand == 0)
        {
           // TweenMax.to("#midLeftDiv",2,{width:"30%",height:"50%",transform:"rotateY(360deg)"});
            TweenMax.to("#randomPic",2,{opacity:"1",borderRadius:("0px"),transform:("scale(1) rotateY(360deg)"),ease: Expo.easeIn})
            document.getElementById("randomPic").src = "images/strawberryTwo.jpg"
        }
        else if (rand == 1)
        {
          //  TweenMax.to("#midLeftDiv",2,{width:"30%",height:"50%",transform:"rotateY(360deg)"});
            TweenMax.to("#randomPic",2,{opacity:"1",borderRadius:("0px"),transform:("scale(1) rotateY(360deg)"),ease: Expo.easeIn})
            document.getElementById("randomPic").src = "images/flowerSun.jpg"
        }
        else if (rand == 2)
        {
         //   TweenMax.to("#midLeftDiv",2,{width:"30%",height:"50%",transform:"rotateY(360deg)"});
            TweenMax.to("#randomPic",2,{opacity:"1",borderRadius:("0px"),transform:("scale(1) rotateY(360deg)"),ease: Expo.easeIn})
            document.getElementById("randomPic").src = "images/tomatoOne.jpg"
        }
        else if (rand == 3)
        {
            //   TweenMax.to("#midLeftDiv",2,{width:"30%",height:"50%",transform:"rotateY(360deg)"});
            TweenMax.to("#randomPic",2,{opacity:"1",borderRadius:("0px"),transform:("scale(1) rotateY(360deg)"),ease: Expo.easeIn})
            document.getElementById("randomPic").src = "images/roundFlower.jpg"
        }
        else if (rand == 4)
        {
            //   TweenMax.to("#midLeftDiv",2,{width:"30%",height:"50%",transform:"rotateY(360deg)"});
            TweenMax.to("#randomPic",2,{opacity:"1",borderRadius:("0px"),transform:("scale(1) rotateY(360deg)"),ease: Expo.easeIn})
            document.getElementById("randomPic").src = "images/rose.jpg"
        }
        else
        {
          //  TweenMax.to("#midLeftDiv",2,{width:"30%",height:"50%",transform:"rotateY(360deg)"});
            TweenMax.to("#randomPic",2,{opacity:"1",borderRadius:("0px"),transform:("scale(1) rotateY(360deg)"),ease: Expo.easeIn})
            TweenMax.to( "#hiddenBotDiv",2,{opacity:"0",ease:Bounce.easeOut})
            document.getElementById("randomPic").src = "images/raspberryOne.jpg" 
        }
        
}
