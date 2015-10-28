<div class="social-network-list">
  <ul>
  <?php foreach ($list as $item){ ?>
    <li>
    	<a href="<?php print $item['url']; ?>" title="<?php print $item['name']; ?>" data-social-network="<?php print $item['machine_name']; ?>" rel="external"><i class="fa fa-<?php print $item['machine_name']; ?>"></i> <span class="label"><?php print $item['name']; ?></span></a>
    </li>
  <?php } ?>
  </ul>
</div>