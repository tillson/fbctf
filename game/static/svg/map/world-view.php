<?hh //strict

require_once($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php');

class WorldViewMapController {
  private bool $viewmode;

  public function __construct($viewmode) {
    $this->viewmode = $viewmode;
  }

  public function render(): :xhp {
    if ($this->viewmode) {
      $worldMap = $this->renderWorldMapView();
    } else {
      $worldMap = $this->renderWorldMap();
    }
    return
      <svg id="fb-gameboard-map" xmlns="http://www.w3.org/2000/svg" xmlns:amcharts="http://amcharts.com/ammap" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1008 651" preserveAspectRatio="xMidYMid meet">
        <defs>
          <amcharts:ammap projection="mercator" leftLongitude="-169.6" topLatitude="83.68" rightLongitude="190.25" bottomLatitude="-55.55"></amcharts:ammap>
        </defs>
        <g class="view-controller">
          <g class="countries">
            {$worldMap}
          </g>
          <g class="country-hover"></g>
        </g><!-- view-controller -->
      </svg>;
  }

  public function renderWorldMap(): :xhp {
    $svg_countries = <g class="countries"></g>;

  return $svg_countries;
  }

  public function renderWorldMapView(): :xhp {
    $svg_countries = <g class="countries"></g>;
    foreach (Country::allMapCountries() as $country) {
      $path_class = ($country->getUsed() && Country::isActiveLevel($country->getId()))
        ? 'land active'
        : 'land';

      $svg_countries->appendChild(
        <g>
          <path id={$country->getIsoCode()['iso_code']} title={$country->getName()} class={$path_class} d={$country->getD()}></path>
          <g transform={$country->getTransform()} class="map-indicator">
            <path d="M0,9.1L4.8,0h0.1l4.8,9.1v0L0,9.1L0,9.1z"></path>
          </g>
        </g>
      );
    }

    return $svg_countries;
  }
}

$viewmodepage = new WorldViewMapController(true);
echo $viewmodepage->render();