// painiketoimintoja HTML-transkriptiossa

// popup-kommentit; sivutus (edellinen- ja seuraava-painikkeet)
$(document).ready(function() {
 
      // hakee comments.js-listan avaimet tekstistä ja luo niille linkin ja tooltipin
      $.each(comments, function(key, value) {
         var first = $('.exhibit1b').text().indexOf(key);
         if (first >= 0) {
            var last = first + key.length;
            var ext = $('.exhibit1b').text().indexOf(' ', last);
            var ending = $('.exhibit1b').text().substring(last, ext);
 
            if (ending.indexOf(",") >= 0) {
              ending = ending.substring(0, ending.indexOf(","));
            } else if (ending.indexOf(".") >= 0) {
              ending = ending.substring(0, ending.indexOf("."));
            } else if (ending.indexOf(";") >= 0) {
              ending = ending.substring(0, ending.indexOf(";"));
            } else if (ending.indexOf(":") >= 0) {
              ending = ending.substring(0, ending.indexOf(":"));
            }

            var str = key + ending;

            $('.exhibit1b')
            .html($('.exhibit1b')
            .html()
            .replace(str, '<a class="comm tooltip bt" href="#">' + str + '<span>' + value + '</span></a>'));
         }
     });

     var i = 0;

     // takaisin-painike: näyttää edellisen, piilottaa muut; laukaisee UV:n takaisin-painikkeen
     $('.btPrevHTML').click(function() {
        if (i == 0) {
           return false;
        }
        $('.page:eq(' + i + ')').hide();
        if ($('.page:eq(' + i + ')').prev()) {
           $('.page:eq(' + i + ')').prev().show().prevAll().hide();
        }
        var bt = $("div.uv.omeka-test-letters:eq(0) iframe").contents().find("div.paging.btn.prev");
        bt.trigger("click");
        i--;
     });

     // seuraava-painike: näyttää seuraavan, piilottaa muut; laukaisee UV:n seuraava-painikkeen
     $('.btNextHTML').click(function(e) {
        if (i == $('.page').length-1) {
           return false;
        }
        $('.page:eq(' + i + ')').hide();
        if ($('.page:eq(' + i + ')').next()) {
           $('.page:eq(' + i + ')').next().show().siblings('.page').hide();
        }
        var bt = $("div.uv.omeka-test-letters iframe").eq(0).contents().find("div.paging.btn.next");
        bt.trigger("click");
        i++;
     });
});
