@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('restaurant.index')}}">Restaurant</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    {{-- Title --}}
    <h1>Create Restaurant</h1>

    {{-- Actual Edit Form --}}
    <form method="POST" action="{{route('restaurant.store')}}" enctype="multipart/form-data">
        @csrf

        {{-- Owner --}}
        <div class="card border-primary mb-3">
            <div class="card-header d-flex">
                {{-- Title --}}
                <p class="lead m-0 align-self-center mr-3">Assign to the user</p>

                {{-- Userlist dropdown --}}
                <div class="autocomplete flex-fill">
                    <input id="ownerInput" type="text" class="form-control" name="owner" placeholder="Owner" required>
                </div>
                @error('owner')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="form-group"> {{-- Name --}}
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" required>
            @error('name')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Description --}}
            <label for="description">Description</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{old('description')}}" required>
            @error('description')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Address --}}
            <label for="address">Address</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{old('address')}}" required>
            @error('address')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Phone --}}
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="+385 12 3456789" pattern="(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?" value="{{old('phone')}}" required>
            <small class="form-text text-muted">FORMAT: +385 12 3456789</small>
            @error('phone')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Website --}}
            <label for="website">Website</label>
            <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" placeholder="https://example.com" pattern="http[s]?://.*" id="website" value="{{old('website')}}" required>
            <small class="form-text text-muted">FORMAT: https://www.example.com</small>
            @error('website')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Categories --}}
            <label for="categories">Categories</label>
            <div class="table-responsive">
                <table class="table table-striped border">
                    <thead>
                        <tr>
                            <th scope="col">Category 1</th>
                            <th scope="col">Category 2</th>
                            <th scope="col">Category 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @for ($i = 0; $i < 3; $i++)
                                <td>
                                    <select name="category[]" class="custom-select">
                                        <option value=""></option> {{-- Default blank --}}
                                        @foreach ($categories as $category)
                                            <option value="{{$category->name}}" @if(old('category.'.$i) == $category->name){{"selected"}}@endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category.'.$i)
                                        <small class="form-text text-danger">{{$message}}</small>
                                    @enderror
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group"> {{-- Image --}}
            <label class="d-block" for="file">Image</label>
            <input type="file" class="form-control-file" name="file" id="file">
            <small class="form-text text-muted">NOTE: Image will be resized to 320x240.</small>
            @error('file')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">✉ Submit</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function autocomplete(inp, arr) {
        var currentFocus;
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                b.addEventListener("click", function(e) {
                    inp.value = this.getElementsByTagName("input")[0].value;
                    closeAllLists();
                });
                a.appendChild(b);
                }
            }
        });
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) { //up
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
            }
        }
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }
    var users = {!! $users !!};

    autocomplete(document.getElementById("ownerInput"), users);
</script>
@endpush
