<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.jobs.index') }}">
                    <input type="hidden" name="open" value="{{ request()->get('open') }}"/>
                    <div class="row">
                        <div class="col-sm-2 mb-2">
                            <label for="job">Job</label>
                            <input type="text" class="form-control form-control-sm" id="job" name="job" value="{{ $filter['job'] }}">
                        </div>
                        <div class="col-sm-2 mb-2">
                            <label for="employer">Employer</label>
                            <input type="text" class="form-control form-control-sm" id="employer" name="employer" value="{{ $filter['employer'] }}">
                        </div>
                        <div class="col-sm-2 mb-2">
                            <label for="type">Type</label>
                            <select name="type" id="typees" class="form-select form-control-sm">
                                <option value=""></option>
                                <option value="Full-Time" {{ $filter['type'] == "Full-Time" ? "selected" : "" }}>Full-Time</option>
                                <option value="Part-Time" {{ $filter['type'] == "Part-Time" ? "selected" : "" }}>Part-Time</option>
                                <option value="Contract" {{ $filter['type'] == "Contract" ? "selected" : "" }}>Contract</option>
                            </select>
                        </div>
                        <div class="col-sm-2 mb-2">
                            <label for="phone">Skills</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="skill" value="{{ $filter['skill'] }}">
                        </div>
                        <div class="col-sm-2 mb-2">
                            <label for="type">Status</label>
                            <select name="status" id="statuses" class="form-select form-control-sm">
                                <option value=""></option>
                                <option value="pending" {{ $filter['status'] == "pending" ? "selected" : "" }}>Pending</option>
                                <option value="approved" {{ $filter['status'] == "approved" ? "selected" : "" }}>Approved</option>
                            </select>
                        </div>
                        <div class="col-sm-2 mb-2 text-end">
                            <button type="submit" class="btn btn-sm btn-secondary"
                                style="margin-top:22px;">Filter</button>
                            <a href="{{ route('admin.jobs.index', ['open' => request()->get('open')]) }}" class="btn btn-sm btn-dark ms-1"
                                style="margin-top:22px;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
