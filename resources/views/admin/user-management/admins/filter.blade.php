<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.admins.index') }}">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $filter['name'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ $filter['email'] }}">
                        </div>
                        <div class="col-sm-2 mb-2">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="{{ $filter['phone'] }}">
                        </div>                        
                        <div class="col-sm-2 mb-2">
                            <label for="name">Status</label>
                            <select name="status" id="statuses" class="form-select form-control-sm">
                                <option value=""></option>
                                <option value="Yes" {{ $filter['status'] == "Yes" ? "selected" : "" }}>Yes</option>
                                <option value="No" {{ $filter['status'] == "No" ? "selected" : "" }}>No</option>
                            </select>
                        </div>
                        <div class="col-sm-2 mb-2 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary"
                                style="margin-top:22px;">Filter</button>
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-dark ms-1"
                                style="margin-top:22px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
