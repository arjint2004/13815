

{{ post }}

<div class="post">

	<h3>{{ title }}</h3>

	<div class="meta">

		<div class="date">
			{{ helper:lang line="movie:posted_label" }}
			<span>{{ helper:date timestamp=created_on }}</span>
		</div>

		<div class="author">
			{{ helper:lang line="movie:written_by_label" }}
			<span><a href="{{ url:site }}user/{{ created_by:user_id }}">{{ created_by:display_name }}</a></span>
		</div>

		{{ if category }}
		<div class="category">
			{{ helper:lang line="movie:category_label" }}
			<span><a href="{{ url:site }}movie/category/{{ category:slug }}">{{ category:title }}</a></span>
		</div>
		{{ endif }}

		{{ if keywords }}
		<div class="keywords">
			{{ keywords }}
				<span><a href="{{ url:site }}movie/tagged/{{ keyword }}">{{ keyword }}</a></span>
			{{ /keywords }}
		</div>
		{{ endif }}

	</div>

	<div class="body">
		{{ body }}
	</div>

</div>

{{ /post }}

<?php if (Settings::get('enable_commentmovies')): ?>

<div id="commentmovies">

	<div id="existing-commentmovies">
		<h4><?php echo lang('commentmovies:title') ?></h4>
		<?php echo $this->commentmovies->display() ?>
	</div>

	<?php if ($form_display): ?>
		<?php echo $this->commentmovies->form() ?>
	<?php else: ?>
	<?php echo sprintf(lang('movie:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['commentmovies_enabled'])))) ?>
	<?php endif ?>
</div>

<?php endif ?>
