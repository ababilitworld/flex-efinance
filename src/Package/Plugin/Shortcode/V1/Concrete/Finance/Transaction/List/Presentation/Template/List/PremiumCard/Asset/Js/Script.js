document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.finance-transaction-list-app').forEach(function (app) {
    var items = Array.from(app.querySelectorAll('.faih-list-item'));
    var empty = app.querySelector('.finance-transaction-list-empty');
    var search = app.querySelector('[data-transaction-search]');
    var pagination = app.querySelector('[data-pagination]');
    var paginationType = pagination ? pagination.getAttribute('data-pagination-type') : 'none';
    var perPage = pagination ? Math.max(1, parseInt(pagination.getAttribute('data-per-page'), 10) || 10) : items.length;
    var currentPage = 1;
    var loadedCount = perPage;
    var matchedItems = items.slice();

    function selectedValues(selector, attribute) {
      var groups = {};
      app.querySelectorAll(selector + ':checked').forEach(function (input) {
        var key = input.getAttribute(attribute);
        groups[key] = groups[key] || [];
        groups[key].push(input.value.toLowerCase());
      });
      return groups;
    }

    function matchesGroups(item, groups, prefix) {
      return Object.keys(groups).every(function (key) {
        var values = (item.getAttribute(prefix + key) || '').toLowerCase().split('|');
        return groups[key].some(function (selected) {
          return values.indexOf(selected) !== -1;
        });
      });
    }

    function renderPageButtons(totalPages) {
      if (!pagination) return;
      var container = pagination.querySelector('[data-pagination-pages]');
      if (!container) return;
      container.innerHTML = '';

      for (var page = 1; page <= totalPages; page += 1) {
        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'faih-pagination-button' + (page === currentPage ? ' is-active' : '');
        button.textContent = page;
        button.setAttribute('aria-label', 'Page ' + page);
        button.setAttribute('aria-current', page === currentPage ? 'page' : 'false');
        button.dataset.page = page;
        container.appendChild(button);
      }
    }

    function renderPagination() {
      var total = matchedItems.length;
      var totalPages = Math.max(1, Math.ceil(total / perPage));
      currentPage = Math.min(currentPage, totalPages);

      items.forEach(function (item) { item.hidden = true; });

      if (paginationType === 'paged' || paginationType === 'previous-next') {
        var start = (currentPage - 1) * perPage;
        matchedItems.slice(start, start + perPage).forEach(function (item) { item.hidden = false; });
      } else if (paginationType === 'load-more') {
        matchedItems.slice(0, loadedCount).forEach(function (item) { item.hidden = false; });
      } else {
        matchedItems.forEach(function (item) { item.hidden = false; });
      }

      if (empty) empty.hidden = total !== 0;
      if (!pagination) return;

      pagination.hidden = total === 0 || total <= perPage;
      var previous = pagination.querySelector('[data-page-previous]');
      var next = pagination.querySelector('[data-page-next]');
      var more = pagination.querySelector('[data-load-more]');
      var status = pagination.querySelector('[data-pagination-status]');

      if (previous) previous.disabled = currentPage <= 1;
      if (next) next.disabled = currentPage >= totalPages;
      if (more) more.disabled = loadedCount >= total;
      if (status) {
        var shown = paginationType === 'load-more' ? Math.min(loadedCount, total) : Math.min(currentPage * perPage, total);
        status.textContent = shown + ' of ' + total;
      }
      if (paginationType === 'paged') renderPageButtons(totalPages);
    }

    function applyFilters() {
      var query = search ? search.value.trim().toLowerCase() : '';
      var taxonomies = selectedValues('[data-filter-taxonomy]', 'data-filter-taxonomy');
      var metas = selectedValues('[data-filter-meta]', 'data-filter-meta');

      matchedItems = items.filter(function (item) {
        var searchable = (item.textContent + ' ' + (item.getAttribute('data-search') || '')).toLowerCase();
        return (!query || searchable.indexOf(query) !== -1) &&
          matchesGroups(item, taxonomies, 'data-tax-') &&
          matchesGroups(item, metas, 'data-meta-');
      });

      currentPage = 1;
      loadedCount = perPage;
      renderPagination();
    }

    app.addEventListener('change', function (event) {
      if (event.target.matches('[data-filter-taxonomy], [data-filter-meta]')) applyFilters();
    });

    if (search) search.addEventListener('input', applyFilters);

    if (pagination) {
      pagination.addEventListener('click', function (event) {
        var pageButton = event.target.closest('[data-page]');
        if (pageButton) currentPage = parseInt(pageButton.dataset.page, 10);
        if (event.target.closest('[data-page-previous]')) currentPage -= 1;
        if (event.target.closest('[data-page-next]')) currentPage += 1;
        if (event.target.closest('[data-load-more]')) loadedCount += perPage;
        renderPagination();
      });
    }

    app.querySelectorAll('[data-transaction-reset]').forEach(function (button) {
      button.addEventListener('click', function () {
        app.querySelectorAll('[data-filter-taxonomy], [data-filter-meta]').forEach(function (input) {
          input.checked = false;
        });
        if (search) search.value = '';
        applyFilters();
      });
    });

    app.querySelectorAll('.faih-filter.attribute-collapsible [data-filter-toggle]').forEach(function (button) {
      button.addEventListener('click', function () {
        var filter = button.closest('.faih-filter');
        var collapsed = filter.classList.toggle('is-collapsed');
        button.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
      });
    });

    applyFilters();
  });
});
