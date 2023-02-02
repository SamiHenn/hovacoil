(function($){
    $(window).on("load",function(){

        $(".scroll-content").mCustomScrollbar({
            scrollButtons:{
                enable:true
            },
            callbacks:{
                onScrollStart:function(){ myCallback(this,"#onScrollStart") },
                onScroll:function(){ myCallback(this,"#onScroll") },
                onTotalScroll:function(){ myCallback(this,"#onTotalScroll") },
                onTotalScrollOffset:60,
                onTotalScrollBack:function(){ myCallback(this,"#onTotalScrollBack") },
                onTotalScrollBackOffset:50,
                whileScrolling:function(){
                    myCallback(this,"#whileScrolling");
                    $("#mcs-top").text(this.mcs.top);
                    $("#mcs-dragger-top").text(this.mcs.draggerTop);
                    $("#mcs-top-pct").text(this.mcs.topPct+"%");
                    $("#mcs-direction").text(this.mcs.direction);
                    $("#mcs-total-scroll-offset").text("60");
                    $("#mcs-total-scroll-back-offset").text("50");
                },
                alwaysTriggerOffsets:false
            }
        });

        function myCallback(el,id){
            if($(id).css("opacity")<1){return;}
            var span=$(id).find("span");
            clearTimeout(timeout);
            span.addClass("on");
            var timeout=setTimeout(function(){span.removeClass("on")},350);
        }

        $(".callbacks a").click(function(e){
            e.preventDefault();
            $(this).parent().toggleClass("off");
            if($(e.target).parent().attr("id")==="alwaysTriggerOffsets"){
                var opts=$(".content").data("mCS").opt;
                if(opts.callbacks.alwaysTriggerOffsets){
                    opts.callbacks.alwaysTriggerOffsets=false;
                }else{
                    opts.callbacks.alwaysTriggerOffsets=true;
                }
            }
        });

    });
})(jQuery);