<article class="uk-article">

    <h1 class="uk-article-title">Gallery</h1>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.slick').slick({
                lazyLoad: 'ondemand'
            });
        });

        $("body").keydown(function(e){
            // left arrow
            if ((e.keyCode || e.which) == 37)
            {
                jQuery('.slick-prev').click();
            }
            // right arrow
            if ((e.keyCode || e.which) == 39)
            {
                jQuery('.slick-next').click();
            }
        });

    </script>

    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-1">
            <div class="slick">

                <?php
                    //Getting captions
                    $captionFiles = scandir('pages/gallery_captions');
                    $captions = array();

                    foreach($captionFiles as $file){
                        $path = 'pages/gallery_captions/'.$file;

                        if(!is_dir($path)){
                            $name = str_replace('.html', '', $file);
                            $captions[$name] = file_get_contents($path);
                        }
                    }


                    $imgs = scandir('img/screens/');
                ?>
                <?php foreach($imgs as $img) : ?>

                    <?php if(!is_dir('img/screens/'.$img)) : ?>

                        <?php if(isset($captions[$img])) : ?>

                            <div class="uk-overlay">
                                <img data-lazy="img/screens/<?php echo $img; ?>"/>
                                <div class="uk-overlay-caption">
                                    <?php echo $captions[$img] ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div>
                                <img data-lazy="img/screens/<?php echo $img; ?>"/>
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
            </p>
        </div>
</article>

<div class="uk-overlay">
    <img src="" alt="">
    <div class="uk-overlay-caption">...</div>
</div>