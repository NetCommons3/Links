<style>
ul.links_category_list>li:not(:last-child) {
		background-image:url('http://www.netcommons.org/images/common/line/line_c3.gif');
		/*height: 5px; */
		/* Android 4 だとbottomからピクセル指定できないので padding, marginで対応*/
		padding-bottom:3px;
		background-position: left bottom;
		margin-bottom: 3px;
		background-repeat: repeat-x;
	}
</style>
<div class="col-sm-12">
	<ul class="nav nav-pills nav-stacked links_category_list" >
		<?php foreach($categories as $category): ?>
			<li class="links_category_item">
				<?php echo $category['LinkCategory']['name'] ?>
				<ul class="nav nav-pills nav-stacked">
					<?php foreach($category['links'] as $link): ?>
						<li>
							<a href="/links/links/visit/<?php echo $link['Link']['id'] ?>">
								<?php echo h($link['Link']['title']) ?>
								<span class="badge"><?php echo $link['Link']['click_number']?></span>
								<?php echo $this->LinksStatus->view($link['Link']['status']); ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</li>
		<?php endforeach ?>
	</ul>
</div>
