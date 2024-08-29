<form action="{{ route('frontend.jobs') }}" method="GET" id="form-filter">
    <div class="Filter mob-filter">
        <div class="text-left d-grid">
            <a href="{{ route('frontend.jobs') }}" class="btn btn-primary">Reset All</a>
        </div>
        <div class="TypeJob">
            <h6>Jobs By Title</h6>
            <ul class="list-unstyled">
                @foreach ($positions as $name => $count)
                    <li>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="flexCheckDefault"
                                value="{{ $name }}" name="positions[]" onchange="getFilterData()"
                                @if (is_array(Request::get('positions')) && in_array($name, Request::get('positions'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault">{{ $name }}</label></div>
                        <div class="openings-total">
                            {{ $count }}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob">
            <h6>Jobs By Region</h6>
            <ul class="list-unstyled">
                @foreach ($regions as $region)
                    <li>
                        <div class="form-check"><input name="region[]"class="form-check-input" type="checkbox"
                                id="flexCheckDefault9" value="{{ $region->id }}" onchange="getFilterData()"
                                @if (is_array(Request::get('region')) && in_array($region->id, Request::get('region'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault9">{{ $region->name }}</label>

                        </div>
                        <div class="openings-total">
                            {{ $region->openjobs() }}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob">
            <h6>Jobs By Area</h6>
            <ul class="list-unstyled">
                @foreach ($areas as $area)
                    <li>
                        <div class="form-check"><input name="area[]"class="form-check-input" type="checkbox"
                                id="flexCheckDefault9" value="{{ $area->id }}" onchange="getFilterData()"
                                @if (is_array(Request::get('area')) && in_array($area->id, Request::get('area'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault9">{{ $area->name }}</label>

                        </div>
                        <div class="openings-total">
                            {{ $area->openjobs() }}
                        </div>
                    </li>
                @endforeach

            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob">
            <h6>Jobs By Sub Zone</h6>
            <ul class="list-unstyled">
                @foreach ($sub_zones as $sub_zone)
                    <li>
                        <div class="form-check"><input name="sub_zone[]" class="form-check-input" type="checkbox"
                                id="flexCheckDefault9" value="{{ $sub_zone->id }}" onchange="getFilterData()"
                                @if (is_array(Request::get('sub_zone')) && in_array($sub_zone->id, Request::get('sub_zone'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault9">{{ $sub_zone->name }}</label>

                        </div>
                        <div class="openings-total">
                            {{ $sub_zone->openjobs() }}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob">
            <h6>Jobs By Job Type</h6>
            <ul class="list-unstyled">
                @foreach ($position_types as $key => $value)
                    <li>
                        <div class="form-check"><input name="job_types[]" class="form-check-input" type="checkbox"
                                id="flexCheckDefault21" value="{{ $key }}" onchange="getFilterData()"
                                @if (is_array(Request::get('job_types')) && in_array($key, Request::get('job_types'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault21">{{ $key }}</label></div>
                        <div class="openings-total">
                            {{ $value }}
                        </div>
                    </li>
                @endforeach

            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob">
            <h6>Jobs By Job Shift</h6>
            <ul class="list-unstyled">
                @foreach ($shift_types as $key => $value)
                    <li>
                        <div class="form-check"><input name="shift[]" class="form-check-input" type="checkbox"
                                id="flexCheckDefault24" value="{{ $key }}" onchange="getFilterData()"
                                @if (is_array(Request::get('shift')) && in_array($key, Request::get('shift'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault24">{{ $key }}</label></div>
                        <div class="openings-total">
                            {{ $value }}
                        </div>
                    </li>
                @endforeach

            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
       
        <div class="TypeJob">
            <h6>Jobs By Career Level</h6>
            <ul class="list-unstyled">
                @foreach ($career_levels as $key => $value)
                    <li>
                        <div class="form-check"><input name="career_level[]" class="form-check-input" type="checkbox" id="flexCheckDefault27"
                                value="{{ $key }}" onchange="getFilterData()"
                                @if (is_array(Request::get('career_level')) && in_array($key, Request::get('career_level'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault27" >{{ $key }}
                            </label></div>
                        <div class="openings-total">
                            {{ $value }}
                        </div>

                    </li>
                @endforeach

            </ul>
        </div>
        <div class="TypeJob">
            <h6>Jobs By Gender</h6>
            <ul class="list-unstyled">
                @foreach ($genders as $key => $value)
                    <li>
                        <div class="form-check"><input name="gender[]" class="form-check-input" type="checkbox" id="flexCheckDefault33"
                                value="{{ $key }}" onchange="getFilterData()"
                                @if (is_array(Request::get('gender')) && in_array($key, Request::get('gender'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault33">{{ $key }}</label></div>
                        <div class="openings-total">
                            {{ $value }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="TypeJob">
            <h6>Jobs By Degree</h6>
            <ul class="list-unstyled">
                @foreach ($educations as $education)
                    <li>
                        <div class="form-check"><input name="education[]" class="form-check-input" type="checkbox" id="flexCheckDefault38"
                                value="{{ $education }}" onchange="getFilterData()"
                                @if (is_array(Request::get('education')) && in_array($education, Request::get('education'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault38">{{ $education }}</label></div>
                        <div class="openings-total">
                            {{ Helper::getJobByEducations($education) }}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob" style="display: none;">
            <h6>Jobs By Skill</h6>
            <ul class="list-unstyled">
                @foreach ($skills as $skill)
                    <li>
                        <div class="form-check"><input name="skill[]" class="form-check-input" type="checkbox"
                                id="flexCheckDefault38" value="{{ $skill }}" onchange="getFilterData()"
                                @if (is_array(Request::get('skill')) && in_array($skill, Request::get('skill'))) checked @endif><label class="form-check-label"
                                for="flexCheckDefault38">{{ $skill }}</label></div>
                        <div class="openings-total">
                            {{ Helper::getJobBySkills($skill) }}
                        </div>
                    </li>
                @endforeach
            </ul>
            {{-- <a href="#" class="View_More">View More</a> --}}
        </div>
        <div class="TypeJob">
            <h6>Jobs By Time</h6>
            <select name="time" id="time" class="form-select" onchange="getFilterData()">
                <option value="">All</option>
                <option value="Most Recent" {{ Request::get('time') == 'Most Recent' ? 'selected' : '' }}>Most Recent</option>
                <option value="Oldest" {{ Request::get('time') == 'Oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
        </div>
        <div class="TypeJob">
            <h6>Jobs By Salary</h6>
            <select name="salary" id="salary" class="form-select" onchange="getFilterData()">
                <option value="">All</option>
                <option value="Highest" {{ Request::get('salary') == 'Highest' ? 'selected' : '' }}>Highest</option>
                <option value="Lowest" {{ Request::get('salary') == 'Lowest' ? 'selected' : '' }}>Lowest</option>
            </select>
        </div>
        <div class="TypeJob">
            <h6>Salary Range</h6>
            <div class="form-group mb-2">
                <input class="form-control filterlocation" name="salary_from" type="number" placeholder="Salary From" onfocusout="getFilterData()"  value="{{ $filter_salary_from }}">
            </div>
            <div class="form-group mb-2">
                <input class="form-control filterlocation" name="salary_upto" type="number" placeholder="Salary To" onfocusout="getFilterData()"  value="{{ $filter_salary_upto }}">
            </div>
            {{-- <div class="form-group">
                <button type="button" class="btn btn-primary btn-block w-100"><i class="fa fa-search"></i> Search
                    Jobs</button>
            </div> --}}
        </div>
    </div>
</form>
