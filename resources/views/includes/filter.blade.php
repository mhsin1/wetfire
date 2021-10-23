<div class="category-page-wrapper">
        <div class="col-md-6 list-grid-wrapper">
          <div class="btn-group btn-list-grid">
            <!-- <button type="button" id="list-view" class="btn btn-default list" data-toggle="tooltip" title="List"><i class="fa fa-th-list"></i></button> -->
            <!-- <button type="button" id="grid-view" class="btn btn-default grid" data-toggle="tooltip" title="Grid"><i class="fa fa-th"></i></button> -->
          </div>
          <a href="#" id="compare-total">There are {{ $prods->total() }} Products</a> </div>
        <div class="col-md-2 text-right sort-wrapper">
          <label class="control-label" for="input-sort">Sort By:</label>
          <div class="sort-inner">
            <select id="sortby" class="sorting sorter form-control" name="sort">
              <option value="" selected="selected">Default</option>
              <option value="date_desc">{{$langg->lang65}}</option>
              <option value="date_asc">{{$langg->lang66}}</option>
              <option value="price_asc">{{$langg->lang67}}</option>
              <option value="price_desc">{{$langg->lang68}}</option>                    
            </select>
          </div>
        </div>
      </div>
