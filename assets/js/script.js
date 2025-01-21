window.onscroll = function() {scrollFunction()};

function scrollFunction() 
{ var link= document.getElementsByClassName("link"),i;
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) 
  { document.getElementById("navbar").style.background="rgb(255,255,255,0.9)";
    document.getElementById("navbar").style.boxShadow="3px 3px 5px rgba(0,0,0,0.1)";
    for (i = 0; i < link.length; i++) 
    { link[i].style.color="black";  
    }
  } 
  else 
  { document.getElementById("navbar").style.background = "rgb(255,255,255,0)";
    document.getElementById("navbar").style.boxShadow="none";
    for (i = 0; i < link.length; i++) 
    { link[i].style.color="white";  
    }
  }
}

function showSidebar(){
    const sidebar=document.querySelector('.menu-bar');
    sidebar.style.right='0%';
}
function hideSidebar(){
    const sidebar=document.querySelector('.menu-bar');
    sidebar.style.right='-100%';
}