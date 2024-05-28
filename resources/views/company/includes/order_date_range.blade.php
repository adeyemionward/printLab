<div class="row g-3 mb-3 mt-3">
    <div class="col-md-12">
        <form method="GET"  id="" class="">
            <div class="row">
                <div class="form-group mt-3 mb-3 col-md-3">
                    <label for="exampleFormControlInput1"> Date From: </label>
                    <input type="date"  name="date_from" class="form-control {{ $errors->has('date_from') ? ' is-invalid' : '' }} " value="{{request()->date_from}}"  id="date_from">
                    @error('date_from')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> 

                <div class="form-group mt-3 mb-3 col-md-3">
                    <label for="exampleFormControlInput1"> Date To: </label>
                    <input type="date"  name="date_to" class="form-control {{ $errors->has('date_to') ? ' is-invalid' : '' }} " value="{{request()->date_to}}"  id="date_to">
                    @error('date_to')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3 mb-3 col-md-3">
                    <label for="exampleFormControlInput1"> Location </label>
                    <select class="form-control form-select" name="location">
                            <option value="">All Location</option>
                            @foreach($locations as $location)
                                <option value="{{$location->id}}" @if(isset(request()->location) && $location->id == request()->location) selected @endif>{{$location->city}}</option>
                            @endforeach
                    </select>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3 mb-3 col-md-3">
                    <label for=""> Filter </label> <br>
                    <button class="btn btn-sm btn-success" type="submit" style="width: 200px">
                        <i class="text-white me-2" data-feather="check-circle"></i>Execute
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
