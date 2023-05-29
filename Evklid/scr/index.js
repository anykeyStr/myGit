window.addEventListener('DOMContentLoaded',function(){

  

// SWIPER START
    const swiper = new Swiper('.swiper-container', {
    // Optional parameters
    //   direction: 'vertical',
    loop: true,

    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        
    },

  // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    
    },

  
});
// SWIPER END

// STEPS START

document.querySelectorAll('.work-item').forEach(function(stepBtn){
  stepBtn.addEventListener('click', function(event){
    const path = event.currentTarget.dataset.path
    

    document.querySelectorAll('.step-text').forEach(function(stepTxt){      
      stepTxt.classList.add('unvisible')
    })

    document.querySelectorAll('.work-picture').forEach(function(stepImg){      
      stepImg.classList.add('unvisible')
    })

    document.querySelectorAll(`[data-target="${path}"]`).forEach(function(active){
      active.classList.remove('unvisible')
    })

    

  })
})


// STEPS END

// BURGER-START

document.querySelector('#burger').addEventListener('click', function(){
    document.querySelector('#burger-menu').classList.toggle('is-active')
})


// BURGER-END



    
})