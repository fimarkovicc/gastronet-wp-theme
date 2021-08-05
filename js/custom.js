(function($) {
 "use strict";

 //image upload validate size
var currenturlpath = window.location.pathname;
if(currenturlpath == "/candidate-edit-profile/" || currenturlpath == "/employer-edit-profile/" || currenturlpath == "/agency-edit-profile/"){
  var _URL = window.URL || window.webkitURL;

$("input[type='file']").change(function(e) {
    var file, img;


    if ((file = this.files[0])) {
        img = new Image();

        
          img.onload = function() {
            if(this.width > 150){
              alert(`Image size too big (${this.width}x${this.height}). Choose another image of max. 150x150 px.`);
            };
          };
        
        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(file);


    }

});
}


 // load more applications
 var numApplications = 10;
 var applPage = 1; 
 $('.load-more-applications').click(function(){
  
  var n = this;
  var applCount = $(this).data('count');
  var pid = $(this).data('pid');
  var offset = applPage * 10;
  var perPage = 1;
  

  $.ajax({
    url: customData.root_url+'/wp-json/wp/v2/comments/?post='+pid+'&offset='+offset+'&per_page='+perPage,
    method: 'GET',
    data: {action:'createHTML'},
    success: function(data){
      var obj = JSON.stringify(data);
      var test = jQuery.parseJSON(obj);
      createHTML(test);
      applPage++;
    }
  });

  function createHTML(postData) {
    var HTMLString = '';
    var i;

    for(i=0; i<postData.length; i++) {

      if(postData[i].author_meta.photo){
      var photo = '<div class="single-user-photo-wrap d-flex align-items-center justify-content-center">'+postData[i].author_meta.photo+'</div>'
      }
      else{
      photo = `<div class="single-user-photo-wrap">
      <span class="dashicons dashicons-admin-users" style="font-size:90px; width:auto; height:auto; color:#00ACEE; margin:0 auto; display:block;"></span>
      </div>`
      };
      if(postData[i].author_meta.location.city){
        var city = postData[i].author_meta.location.city+', ';
      }
      if(postData[i].author_meta.location.state){
        var state = postData[i].author_meta.location.state+', ';
      }
      if(postData[i].author_meta.location.country){
        var country = postData[i].author_meta.location.country;
      }

      HTMLString = `
      <div class="user-info mt-4">
      ${photo}
      <div class="single-user-text">  
      <h1>${postData[i].author_meta.first_name} ${postData[i].author_meta.last_name}</h1>
      
      <p class="mb-0 candidate-location"><span class="dashicons dashicons-location mr-0 pt-1"></span><span>
      ${city}${state}${country}
      </span></p>
      <div class="job-application-btn-wrap">
      <a class="application-btn mt-2 mr-2" href="mailto:${postData[i].user_email}?Subject=Your Job application">E-mail candidate</a>
      <a class="application-btn mt-2 mr-2" href="${customData.root_url}/author/${postData[i].author_meta.user_nicename}" target="_blank">View resume</a>
      </div>
      </div>
      <p class="mt-3">${postData[i].content.rendered}</p>
      </div>
      `;
      
    }
  $(n).parents('.item').find('.job-applications-container-inner-load').prepend(HTMLString);
  if(applPage == applCount-1){
    $(n).addClass('disabled').text('No more applications');
  }
  };

 });
 

//apply to job

$('.apply-to-job').on('click', function(){
  $('.job-application').removeClass('hidden');
});
$('.cancel-job-application').on('click', function(){
  $('.job-application').addClass('hidden');
});

//show-hide applications overlay
$('.btn-show-applications').click(function(){
  if(!$(this).hasClass('disabled')){
    $(this).parents('.item').find('.job-applications-container').removeClass('hidden');
    $('body').css({'overflow':'hidden'});
  }
  if($(this).parents('.item').find('.load-more-applications').data('pid') >= numApplications){
    $('.load-more-applications').addClass('hidden');
  }
});



//front page slider
 $(document).ready(function() {
  
  $('#lightSlider').lightSlider({
      item:4,
      loop:false,
      slideMove:1,
      easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
      speed:600,
      controls:true,
      responsive : [
          {
              breakpoint:1000,
              settings: {
                  item:2,
                  slideMove:1,
                  slideMargin:6,
                  controls:true
                }
          },
          {
              breakpoint:580,
              settings: {
                  item:1,
                  slideMove:1,
                  controls:true
                }
          }
      ]
  });  
});


     
    
 
})(jQuery);






