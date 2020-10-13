<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-3xl mb-4">Edit domain</div>
                @include('partials/error-message')


                <form action="/edit-domain/{{$domain->id}}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label for="name">Domain name</label>
                        <input value="{{$domain->name}}" type="text" name="name" id="name" placeholder="Type domain name without http or https & www" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Type description">{{$domain->description}}</textarea>
                    </div>

                    <div class="form-group custom-switch">
                        <input type="checkbox" {{$domain->ssl == 1 ? 'checked' : ''}} class="custom-control-input" id="ssl_editing" name="ssl">
                        <label class="custom-control-label" for="ssl_editing">Have SSL?</label>
                    </div>

                    <div class="form-group custom-switch">
                        <input type="checkbox" {{$domain->force_hosting == 1 ? 'checked' : ''}} class="custom-control-input" id="force_hosting_editing" name="force_hosting">
                        <label class="custom-control-label" for="force_hosting_editing">Force hosting?</label>
                    </div>

                    <div class="form-group">
                        <label for="cms">CMS</label>
                        <input value="{{$domain->cms}}" type="text" name="cms" id="cms" placeholder="Type CMS name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="cms_version">CMS version</label>
                        <input value="{{$domain->cms_version}}" type="number" name="cms_version" id="cms_version" placeholder="Type CMS version" class="form-control" step=".01">
                    </div>

                    <button x-data="{ adddomain: false }" @click="adddomain = true" type="submit" class="btn btn-primary">Update domain <i x-show="adddomain" @click.away="adddomain = false" class="fas fa-spin fa-spinner"></i></button>
                    <a href="/{{$domain->name}}" class="btn btn-secondary" data-dismiss="modal">Close</a>
                </form>





            </div>
        </div>
    </div>
</x-app-layout>
