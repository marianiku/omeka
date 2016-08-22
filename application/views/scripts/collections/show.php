<?php
$collectionTitle = strip_formatting(metadata('collection', array('Dublin Core', 'Title')));
?>

<?php echo head(array('title'=> $collectionTitle, 'bodyclass' => 'collections show')); ?>

<h1><?php echo $collectionTitle; ?></h1>

<?php echo all_element_texts('collection'); ?>

<?php echo pagination_links(); ?>

<?php
$sortLinks[__('Kirjoitusaika')] = 'Dublin Core,Date';
$sortLinks[__('Otsikko')] = 'Dublin Core,Title';
?>

<div id="sort-collection-letters">
    <span class="sort-label"><?php echo __('Järjestä: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
</div>

<div id="collection-items">
    <!--<h2><?php echo link_to_items_browse(__('Kirjeet kokoelmassa %s', $collectionTitle), array('collection' => metadata('collection', 'id'))); ?></h2>-->
    <?php if (metadata('collection', 'total_items') > 0): ?>
        <?php foreach (loop('items') as $item): ?>
        <?php $itemTitle = strip_formatting(metadata('item', array('Dublin Core', 'Title'))); ?>
        <div class="item hentry">
            <p><?php echo link_to_item($itemTitle, array('class'=>'permalink')); ?></p>

            <?php if (metadata('item', 'has thumbnail')): ?>
            <div class="item-img">
                <?php echo link_to_item(item_image('square_thumbnail', array('alt' => $itemTitle))); ?>
            </div>
            <?php endif; ?>
            <div class="item-date">
            </div>
            <?php if ($text = metadata('item', array('Item Type Metadata', 'Text'), array('snippet'=>250))): ?>
            <div class="item-description">
                <p>
                  <?php echo "Kirjoitusaika: ".date('j.n.Y', strtotime(metadata('item', array('Dublin Core', 'Date')))); ?><br />
                  <?php echo $text; ?>
                </p>
            </div>
            <?php elseif ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
            <div class="item-description">
                <?php
                $date = metadata('item', array('Dublin Core', 'Date'));
                echo "Kirjoitusaika: ".date('j.n.Y', strtotime($date)); ?><br />
                <?php echo $description; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?php echo __("Kokoelmassa ei ole kirjeitä."); ?></p>
    <?php endif; ?>
</div><!-- end collection-items -->

<?php fire_plugin_hook('public_collections_show', array('view' => $this, 'collection' => $collection)); ?>

<?php echo foot(); ?>
