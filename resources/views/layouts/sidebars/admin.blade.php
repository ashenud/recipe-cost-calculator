<div class="side-bar open-sidebar" id="side-bar">
    <ul class="list-group">
        <li class="side-item">
            <a class="side-link li-dash" href="{{ url('admin/dashboard') }}">
                <i class="bi bi-calculator"></i> Dashboard
            </a>
        </li>
        <li class="side-item">
            <a class="side-link li-ingredient-cat" href="{{ url('/admin/ingredient/category') }}">
                <i class="bi bi-cart-check-fill"></i> Categories
            </a>
        </li>
        <li class="side-item">
            <a class="side-link li-ingredient" href="{{ url('/admin/ingredient') }}">
                <i class="bi bi-cart4"></i> Ingredients
            </a>
        </li>
        <li class="side-item">
            <a class="side-link li-recipe" href="{{ url('/admin/recipe') }}">
                <i class="bi bi-journal-medical"></i> Recipes
            </a>
        </li>
    </ul>
</div>
<div class="sidebar-overlay open-sidebar" id="sidebar-overlay"></div>