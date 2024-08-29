<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.notifications.index') }}">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="type">Action By</label>
                            <select name="action_by" class="form-select form-control-sm">
                                <option value="">Please select</option>
                                <option value="Superadmin" {{ $filter['action_by'] == "Superadmin" ? "selected" : "" }}>Superadmin</option>
                                <option value="Admin" {{ $filter['action_by'] == "Admin" ? "selected" : "" }}>Admin</option>
                                <option value="Account" {{ $filter['action_by'] == "Account" ? "selected" : "" }}>Account</option>
                            </select>
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="phone">Action Date</label>
                            <input type="date" class="form-control form-control-sm" id="phone" name="action_date" value="{{ $filter['action_date'] }}">
                        </div>
                        <div class="col-sm-4 mb-2">
                            <label for="type">Search Log</label>
                             <input type="text" class="form-control form-control-sm" id="phone" name="search" value="{{ $filter['search'] }}">
                            
                        </div>
                        <div class="col-sm-2 mb-2 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary"
                                style="margin-top:22px;">Filter</button>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-dark ms-1"
                                style="margin-top:22px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
