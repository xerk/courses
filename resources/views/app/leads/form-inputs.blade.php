@php $editing = isset($lead) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $lead->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name_ar"
            label="Name Ar"
            value="{{ old('name_ar', ($editing ? $lead->name_ar : '')) }}"
            maxlength="255"
            placeholder="Name Ar"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            value="{{ old('email', ($editing ? $lead->email : '')) }}"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            value="{{ old('phone', ($editing ? $lead->phone : '')) }}"
            maxlength="255"
            placeholder="Phone"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="category_approved"
            label="Category Approved"
            value="{{ old('category_approved', ($editing ? $lead->category_approved : '')) }}"
            maxlength="255"
            placeholder="Category Approved"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="course_type" label="Course Type">
            @php $selected = old('course_type', ($editing ? $lead->course_type : '')) @endphp
            <option value="medical" {{ $selected == 'medical' ? 'selected' : '' }} >Medical</option>
            <option value="technical" {{ $selected == 'technical' ? 'selected' : '' }} >Technical</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="category_id" label="Category" required>
            @php $selected = old('category_id', ($editing ? $lead->category_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Category</option>
            @foreach($categories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="lead_from" label="Lead From">
            @php $selected = old('lead_from', ($editing ? $lead->lead_from : '')) @endphp
            <option value="website" {{ $selected == 'website' ? 'selected' : '' }} >Website</option>
            <option value="calls" {{ $selected == 'calls' ? 'selected' : '' }} >Calls</option>
            <option value="whatsapp" {{ $selected == 'whatsapp' ? 'selected' : '' }} >Whatsapp</option>
            <option value="by_visit" {{ $selected == 'by_visit' ? 'selected' : '' }} >By visit</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $lead->status : '')) }}"
            maxlength="255"
            placeholder="Status"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="business_landline"
            label="Business Landline"
            value="{{ old('business_landline', ($editing ? $lead->business_landline : '')) }}"
            maxlength="255"
            placeholder="Business Landline"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="note" label="Note" maxlength="255"
            >{{ old('note', ($editing ? $lead->note : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
