		<li class="nav-item">
			<?= anchor(route_to('cityList'), '<svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg> '.lang('Cities.moduleTitle'), ['class' => 'nav-link'.($currentModule == strtolower('cities') ? ' active' : '')]); ?>
		</li>
		<li class="nav-item">
			<?= anchor(route_to('countryList'), '<svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg> '.lang('Countries.moduleTitle'), ['class' => 'nav-link'.($currentModule == strtolower('countries') ? ' active' : '')]); ?>
		</li>
		<li class="nav-item">
			<?= anchor(route_to('personList'), '<svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg> '.lang('People.moduleTitle'), ['class' => 'nav-link'.($currentModule == strtolower('people') ? ' active' : '')]); ?>
		</li>
