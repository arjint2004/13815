					<? //print_r($posts); die():?><h2 class="page-heading">Blog Post</h2>
{{ if posts }}

	{{ posts }}                    
                    <!-- News post article-->
                    <article class="post post--news">
                        <a href='{{ url }}' class="post__image-link">
                            {{ image:img }}
                        </a>
						
                        <h1><a href="{{ url }}" class="post__title-link">{{ title }}</a></h1>
                        <p class="post__date">{{ helper:lang line="blog:posted_label" }} {{ helper:date timestamp=created_on }}</p>

                        <div class="wave-devider"></div>

                        <p class="post__text">{{ preview }}</p> 
			
						{{ if keywords }}
                        <div class="tags">
                                <ul>
								{{ keywords }}
                                    <li class="item-wrap"><a href="{{ url:site }}blog/tagged/{{ keyword }}" class="tags__item">{{ keyword }}</a></li>
                                {{ /keywords }}   
                                </ul>
                        </div>
						{{ endif }}
                        <div class="devider-huge"></div>
                    </article> 
                    <!-- end news post article-->



	{{ /posts }}
                    <!--<div class="pagination">
                        <a href='#' class="pagination__prev">prev</a>
                        <a href='#' class="pagination__next">next</a>
                    </div>-->
	{{ pagination }}

{{ else }}
	
	{{ helper:lang line="blog:currently_no_posts" }}

{{ endif }}					