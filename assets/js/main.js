document.addEventListener('DOMContentLoaded',function(){
    const yi=document.getElementById('year-input');
    const ys=document.getElementById('year-slider');
    if(yi&&ys){
        ys.addEventListener('input',function(){yi.value=this.value;});
        yi.addEventListener('input',function(){ys.value=this.value;});
    }
});
