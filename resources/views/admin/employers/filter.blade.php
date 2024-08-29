<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.employers.index') }}">
                    <input type="hidden" name="status" value="{{ request()->get('status') }}"/>
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $filter['name'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ $filter['email'] }}">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="{{ $filter['phone'] }}">
                        </div>
                        <div class="col-sm-3 mb-2 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary"
                                style="margin-top:22px;">Filter</button>
                            <a href="{{ route('admin.employers.index', ['status' => request()->get('status')]) }}" class="btn btn-sm btn-dark ms-1"
                                style="margin-top:22px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
