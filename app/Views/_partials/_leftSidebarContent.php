			<li class="nav-item">
			    <a href="<?=route_to('countries') ?>" class="nav-link<?= $currentModule == strtolower('countries') ? ' active' : ''; ?>">
			        <i class="far fa-circle nav-icon"></i>
			        <p>Countries</p>
			    </a>
			</li>		<li class="nav-item">
			    <a href="<?=route_to('cities') ?>" class="nav-link<?= $currentModule == strtolower('cities') ? ' active' : ''; ?>">
			        <i class="far fa-circle nav-icon"></i>
			        <p>Cities</p>
			    </a>
			</li>		<li class="nav-item">
			    <a href="<?=route_to('people') ?>" class="nav-link<?= $currentModule == strtolower('people') ? ' active' : ''; ?>">
			        <i class="far fa-circle nav-icon"></i>
			        <p>People</p>
			    </a>
			</li>