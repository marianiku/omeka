  <!-- Some English titles and labels displayed in search results replaced with Finnish -->
  <?php

  /**
   * @package     omeka
   * @subpackage  solr-search
   * @copyright   2012 Rector and Board of Visitors, University of Virginia
   * @license     http://www.apache.org/licenses/LICENSE-2.0.html
   */

  ?>


  <?php queue_css_file('results'); ?>
  <?php echo head(array('title' => __('Solr search')));?>

  <h3><?php echo __('Search Terms'); ?></h3>
  <!-- Search form. -->
  <div class="solr">
    <form id="solr-search-form">
      <input type="submit" value="<?php echo __('Search'); ?>" />
      <span class="float-wrap">
        <input type="text" title="<?php echo __('Search for keywords') ?>" name="q" value="<?php
          echo array_key_exists('q', $_GET) ? $_GET['q'] : '';
        ?>" placeholder="<?php echo __('Search for letters');?>"/> <!-- add placeholder in input field -->
      </span>
    </form>
  </div>

  <!-- Applied facets. -->

  <div id="solr-applied-facets">
    <ul>

      <!-- Get the applied facets. -->
      <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
        <li>
          <!-- Facet label. -->
          <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
          <?php
          $label = str_replace('XML File', 'Kirjoituspaikka', $label);
          ?>

          <span class="applied-facet-label" style="font-weight:bold;"><?php echo $label." - "; ?></span>
          <!-- Capitalize specific labels in search results view -->
          <?php if ($label == 'Kirjoituspaikka'): ?>
            <span class="applied-facet-value"><?php echo ucfirst($f[1]); ?></span>
          <?php else: ?>
            <span class="applied-facet-value"><?php echo $f[1]; ?></span>
          <?php endif; ?>
          <!-- Remove link. -->
          <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
          (<a href="<?php echo $url; ?>">poista</a>)

        </li>
      <?php endforeach; ?>

    </ul>

  </div>

  <!-- Facets. -->
  <div id="solr-facets">

    <h2><?php echo __('Limit Your Search'); ?></h2>

    <?php foreach ($results->facet_counts->facet_fields as $name => $facets): ?>

      <!-- Does the facet have any hits? -->
      <?php if (count(get_object_vars($facets))): ?>

        <!-- Facet label. -->
        <?php $label = SolrSearch_Helpers_Facet::keyToLabel($name);?>

        <!-- Translations for facet labels (language files) -->
        <?php switch ($label) {
          case "Collection":
              $label = __('Collection');
              break;
          case "Type":
              $label = __('Type');
               break;
          case "Language":
              $label = __('Language');
              break;
          case "XML File":
              $label = __('XML File');
              break;
        }
        if ($label == 'XML-tiedosto') {
          $label = str_replace('XML-tiedosto', 'Kirjoituspaikka', $label);
        }
        ?>

        <strong><?php echo $label; ?></strong>

        <ul>
          <!-- Facets. -->
          <?php foreach ($facets as $value => $count): ?>
            <li class="<?php echo $value; ?>">

              <!-- Facet URL. -->
              <?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>

              <!-- Facet link. -->
              <a href="<?php echo $url; ?>" class="facet-value">
                <!-- Capitalize values in specific facets -->
                <?php if ($label == 'Kirjoituspaikka') {
                  $value = ucfirst($value);
                } ?>
                <?php echo str_replace('merkinta_konseptikirjassa', 'merkintä konseptikirjassa', $value); ?>
              </a>

              <!-- Facet count. -->
              (<span class="facet-count"><?php echo $count; ?></span>)

            </li>
          <?php endforeach; ?>
        </ul>

      <?php endif; ?>

    <?php endforeach; ?>
  </div>


  <!-- Results. -->
  <div id="solr-results">

    <!-- Number found. -->
    <h2 id="num-found">
      <?php echo __('Letters found: %s', $results->response->numFound); ?>
    </h2>

    <!-- Results sorted according to date. -->
    <?php
      usort($results->response->docs, function($a, $b) {
          $date = '40_t';
          return strcmp($a->$date, $b->$date);
        });
    ?>
    <?php foreach ($results->response->docs as $doc): ?>
      <!-- Document. -->
      <div class="result">

        <!-- Header. -->
        <div class="result-header">

          <!-- Record URL. -->
          <?php $url = SolrSearch_Helpers_View::getDocumentUrl($doc); ?>

          <!-- Title. -->
          <a href="<?php echo $url; ?>" class="result-title"><?php
                  $title = is_array($doc->title) ? $doc->title[0] : $doc->title;
                  if (empty($title)) {
                      $title = '<i>' . __('[Untitled]') . '</i>';
                  }
                  // Display letter number and date along with title in search results
                  $number = '43_t';
                  $date = '40_t';
                  echo $doc->$number." - ".$title.", ".date('j.n.Y', strtotime($doc->$date));
              ?></a>

          <!-- Result type. -->
          <!--<span class="result-type">(<?php echo $doc->resulttype; ?>)</span>-->

        </div>

        <!-- Highlighting. -->
        <?php if (get_option('solr_search_hl')): ?>

          <ul class="hl">
            <!-- Make field labels visible in search results -->
            <!-- Get search result object field labels ($prop) as well as values ($field) to display
                 which field a specific result was found in -->
            <?php foreach($results->highlighting->{$doc->id} as $prop=>$field): ?>

              <?php if($prop == 'Laji'):
                $field = str_replace('merkinta_konseptikirjassa', 'merkintä konseptikirjassa', $field);
              endif; ?>
              <?php foreach($field as $hl): ?>
                <!-- Proper names for Solr field codes, translated in language files -->
                <?php echo '<li class="snippet">';?>
                <?php
                switch ($prop) {
                  case "40_t":
                    $prop = __('40_t');
                    break;
                  case "43_t":
                    $prop = __('43_t');
                    break;
                  case "44_t":
                    $prop = __('44_t');
                    break;
                  case "46_t":
                    $prop = __('46_t');
                    break;
                  case "50_t":
                    $prop = __('50_t');
                    break;
                  case "51_t":
                    $prop = __('51_t');
                    break;
                  case "52_t":
                    $prop = __('52_t');
                    break;
                  case "70_t":
                    $prop = __('70_t');
                    break;
                  case "75_t":
                    $prop = __('75_t');
                    break;
                }?>
                <?php echo '<b>'.$prop.'</b>: '.strip_tags($hl, '<em>').'</li>';?>
              <?php endforeach; ?>
            <?php endforeach; ?>

          </ul>
        <?php endif; ?>

        <?php
          $item = get_db()->getTable($doc->model)->find($doc->modelid);
          echo item_image_gallery(
              array('wrapper' => array('class' => 'gallery')),
              'square_thumbnail',
              false,
              $item
          );
        ?>

      </div>

    <?php endforeach; ?>
  <?php echo pagination_links(); ?>
  </div>



  <?php echo foot();
