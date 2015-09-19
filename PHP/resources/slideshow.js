$(function () {
    $('.slideshow').each(function () {
        var $slideshow = $(this);
        $slideshow.find('.images-counter').text($slideshow.find('img').length);
        $slideshow.find('img').not(':first').hide(0);
        $slideshow.data('data-image', 0);
        
        var $images = $slideshow.find('img');
        var currentImage = $slideshow.data('data-image');
        $slideshow.find('.slideshow_comment').text($images.eq(currentImage).attr("alt"));
        
    });

    $('.slideshow img').click(function (e) {
        var $slideshow = $(this).closest('.slideshow');
        var $images = $slideshow.find('img');
        var currentImage = $slideshow.data('data-image');
        var imagesCounter = $images.length;
        $images.eq(currentImage).hide(0);
        currentImage = currentImage >= imagesCounter - 1 ? 0 : currentImage + 1;
        $slideshow.data('data-image', currentImage);
        $images.eq(currentImage).css('display','block');
        $slideshow.find('.current-image-counter').text(currentImage + 1);
        $slideshow.find('.slideshow_comment').text($images.eq(currentImage).attr("alt"));
    });
});
