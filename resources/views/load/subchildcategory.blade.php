<option value="">Select Sub Child Category</option>
@foreach($cat->subchilds as $subchild)
<option value="{{ $subchild->id }}">{{ $subchild->name }}</option>
@endforeach