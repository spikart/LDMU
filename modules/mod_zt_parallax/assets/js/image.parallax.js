    function checkElementOnWindow(element){
        var rect = element.getBoundingClientRect();
        return (rect.bottom > 0 && rect.bottom <= rect.height) ||
            (rect.top > 0 && rect.top <= (window.innerHeight || document.documentElement.clientHeight));
    }
    function imageParallax(image) {

        var windowHeight = window.innerHeight || document.documentElement.clientHeight,
            imageDemension,
            ratioScroll ,
            topChange;


        imageDemension = getDemensions(image);
        var container = jQuery(image).parents(".image-parallax-container").first().get(0);


        var containerDemension = getDemensions(container);
        var maxScrollMove = windowHeight + containerDemension.height;

        var maxImageMove = imageDemension.height - containerDemension.height;
        ratioScroll = maxImageMove/maxScrollMove;
        var left = -(imageDemension.width - containerDemension.width)/2;
        if(checkElementOnWindow(container)) {
            topChange = Math.floor((containerDemension.top - windowHeight) * ratioScroll);
            image.style.top = topChange +"px";
            image.style.left = left +"px";

        }
    }


    function getDemensions(image) {
        var rect = image.getBoundingClientRect();
        return rect;
    }
