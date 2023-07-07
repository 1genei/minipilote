                
                    <div class="table-responsive">
                        <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="tab1">
                            <thead class="table-light">
                                <tr>
                               
                                    <th>Nom</th>                                    
                                    <th>Prénom</th>                                 
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>
                                    <th>Code Postal</th>
                                    <th>Ville</th>

                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactindividus as $contactindividu)
                                    
                               
                                 <tr>
                                   
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->nom}}</a> </td>
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->prenom}}</a> </td>
                                    
                            
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->email}}</a> </td>
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->contact1}} @if($contactindividu->contact2 != null) / {{$contactindividu->contact2}} @endif</a> </td>
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->adresse}}</a> </td>
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->code_postal}}</a> </td>
                                     <td><a href="#" class="text-body fw-bold">{{$contactindividu->individu->ville}}</a> </td>
                                     
                                    
                                     <td>
                                        <a href="{{route('contact.show', Crypt::encrypt($contactindividu->id))}}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a data-href="{{route('prospect.update', $contactindividu->id)}}" 
                                            data-nom="{{$contactindividu->individu->nom}}" data-prenom="{{$contactindividu->individu->prenom}}" data-type-contact="{{$contactindividu->type}}" data-typeentite="{{$contactindividu->individu->type}}" data-id="{{$contactindividu->id}}"
                                            data-email="{{$contactindividu->individu->email}}" data-contact1="{{$contactindividu->individu->contact1}}" data-contact2="{{$contactindividu->individu->contact2}}"
                                            data-adresse="{{$contactindividu->individu->adresse}}" data-code-postal="{{$contactindividu->individu->code_postal}}" data-ville="{{$contactindividu->individu->ville}}"
                                            data-bs-toggle="modal" data-bs-target="#edit-modal" class="action-icon edit-contact text-success"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            
                                        @if($contactindividu->archive == false)
                                        <a data-href="{{route('role.archive', $contactindividu->id)}}" style="cursor: pointer;" class="action-icon archive-role text-warning"> <i class="mdi mdi-archive-arrow-down"></i></a>
                                        @else
                                        <a data-href="{{route('role.unarchive', $contactindividu->id)}}" style="cursor: pointer;" class="action-icon unarchive-role text-success"> <i class="mdi mdi-archive-arrow-up"></i></a>
                                        @endif
                                     </td>
                                 </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    