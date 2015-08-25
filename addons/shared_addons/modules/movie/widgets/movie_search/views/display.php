<div class="col-sm-12">
                <div class="mega-select-present mega-select-top mega-select--full">
                    <div class="mega-select-marker">

                        <div class="marker-indecator cinema">
                            <p class="select-marker"><span>find by </span> <br>title</p>
                        </div>

                        <div class="marker-indecator film-category">
                            <p class="select-marker"><span>find movie due to </span> <br> your mood</p>
                        </div>

                        <div class="marker-indecator actors">
                            <p class="select-marker"><span> like particular stars</span> <br>find them</p>
                        </div>

                        <div class="marker-indecator director">
                            <p class="select-marker"><span>admire personalities - find </span> <br>by director</p>
                        </div>

                        <div class="marker-indecator country">
                            <p class="select-marker"><span>search for movie from certain </span> <br>country?</p>
                        </div>
                    </div>

                      <div class="mega-select pull-right">
                          <span class="mega-select__point">Search by</span>
                          <ul class="mega-select__sort">
							  
                              <li class="filter-wrap"><a href="#" id="title" 	class="mega-select__filter filter--active" data-filter='cinema'>Title</a></li>
							  <li class="filter-wrap"><a href="#" id="category" class="mega-select__filter " data-filter='film-category'>Category</a></li>
                              <li class="filter-wrap"><a href="#" id="actor"  	class="mega-select__filter" data-filter='actors'>Actors</a></li>
                              <li class="filter-wrap"><a href="#" id="director" class="mega-select__filter" data-filter='director'>Director</a></li>
                              <li class="filter-wrap"><a href="#" id="country"  class="mega-select__filter" data-filter='country'>Country</a></li>
                          </ul>

                          <?php echo form_open('movie/search','id="searchhome"');?>
						  <!--<input id="search-inputapp" type="hidden" name="search-input" value="">-->
						  <input id="inputsc" type="hidden" value="" name="searchtype">
                          <input name="search-input"  type='text' class="select__field" />
                          <?php echo form_close();?>
						  <input name="zzz" id="search-input" type='hidden' class="select__field" />
                          <div class="select__btn">
                            <a href="#" class="btn btn-md btn--danger cinema">find <span class="hidden-exrtasm">by title</span></a>
                            <a href="#" class="btn btn-md btn--danger film-category">find <span class="hidden-exrtasm">best category</span></a>
                            <a href="#" class="btn btn-md btn--danger actors">find <span class="hidden-exrtasm">talented actors</span></a>
                            <a href="#" class="btn btn-md btn--danger director">find <span class="hidden-exrtasm">favorite director</span></a>
                            <a href="#" class="btn btn-md btn--danger country">find <span class="hidden-exrtasm">produced country</span></a>
                          </div>

                          <div class="select__dropdowns">
                              <ul class=" cinema">
                              </ul>

                              <ul class=" film-category">

                              </ul>

                              <ul class=" actors">
                              </ul>

                              <ul class=" director">
                              </ul>

                              <ul class=" country">
                              </ul>
                          </div>
                      </div>
                  </div>
            </div>
            
            <div class="clearfix"></div>