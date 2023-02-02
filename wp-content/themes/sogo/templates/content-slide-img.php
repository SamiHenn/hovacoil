<div class="container-fluid">
    <div class="row">
        <div class="slide slider-full-height"
             style="background: url( {{slide.bg.url}} ) center; background-size: cover; background-repeat: no-repeat;">

            <div class="col-lg-12 slider-full-height">

                <div class="inner-slide">
                    <div class="titles">
                        <h2 class="slider-title  ">{{slide.txt.title}}</h2>
                        <h3 class="slider-subtitle  ">{{slide.txt.subtitle}}</h3>
                        <div class="slider-text">
                            {{slide.txt.paragraph}}
                        </div>
                    </div>
                    <div class="read-more">
                        <a class="btn-custom" href="{{slide.btn.href}}" target="{{slide.btn.target}}">

                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            {{slide.btn.text}}

                        </a>
                    </div>
                </div>


            </div>
            <div class="text-center scroll-down-wrapper hidden-xs">
                <a class="arrow-down display-block" href="#content" title="Skip to content" aria-label="גלול למטה">

                    <span class="icon icon-down-01 display-block"></span>

                </a>
            </div>
        </div>
    </div>
</div>