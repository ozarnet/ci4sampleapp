		<li class="nav-item">
			    <a href="<?=route_to('App\Controllers\Countries::index') ?>" class="nav-link<?= $currentModule == strtolower('countries') ? ' active' : ''; ?>">
			        <i class="far fa-circle nav-icon"></i>
			        <p>Countries</p>
			    </a>
			</li>		<li class="nav-item">
			    <a href="<?=route_to('App\Controllers\Cities::index') ?>" class="nav-link<?= $currentModule == strtolower('cities') ? ' active' : ''; ?>">
			        <i class="far fa-circle nav-icon"></i>
			        <p>Cities</p>
			    </a>
			</li>		<li class="nav-item">
			    <a href="<?=route_to('App\Controllers\People::index') ?>" class="nav-link<?= $currentModule == strtolower('people') ? ' active' : ''; ?>">
			        <i class="far fa-circle nav-icon"></i>
			        <p>People</p>
			    </a>
			</li>