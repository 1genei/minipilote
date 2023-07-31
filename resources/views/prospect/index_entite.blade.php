                <div class="table-responsive">
                    <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                        id="tab1">
                        <thead class="table-light">
                            <tr>

                                <th>Nom</th>
                                <th>Type d'entité</th>

                                <th>Membres</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Adresse</th>
                                <th>Code Postal</th>
                                <th>Ville</th>

                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactentites as $contactentite)
                                <tr>

                                    <td><a href="#" class="text-body fw-bold">{{ $contactentite->entite->nom }}</a>
                                    </td>
                                    <td><a href="#" class="text-body fw-bold">{{ $contactentite->entite->type }}</a>
                                    </td>

                                    <td>
                                        <a href="#" style="cursor: pointer;" class="action-icon text-primary">
                                            <i class="mdi mdi-account-group"></i>
                                            {{ $contactentite->entite->nb_membres() }}</a>

                                    </td>
                                    <td><a href="#"
                                            class="text-body fw-bold">{{ decode_string($contactentite->entite->email) }}</a>
                                    </td>
                                    <td><a href="#"
                                            class="text-body fw-bold">{{ $contactentite->entite->telephone_mobile }}
                                            @if ($contactentite->contact2 != null)
                                                / {{ $contactentite->telephone_fixe }}
                                            @endif
                                        </a> </td>
                                    <td><a href="#"
                                            class="text-body fw-bold">{{ $contactentite->entite->adresse }}</a> </td>
                                    <td><a href="#"
                                            class="text-body fw-bold">{{ $contactentite->entite->code_postal }}</a>
                                    </td>
                                    <td><a href="#"
                                            class="text-body fw-bold">{{ $contactentite->entite->ville }}</a> </td>


                                    <td>
                                        <a href="{{ route('contact.show', Crypt::encrypt($contactentite->id)) }}"
                                            class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a href="{{ route('prospect.edit', Crypt::encrypt($contactentite->id)) }}"
                                            class="action-icon edit-contact text-success">
                                            <i class="mdi mdi-square-edit-outline"></i></a>

                                        @if ($contactentite->archive == false)
                                            <a data-href="{{ route('role.archive', $contactentite->id) }}"
                                                style="cursor: pointer;" class="action-icon archive-role text-warning">
                                                <i class="mdi mdi-archive-arrow-down"></i></a>
                                        @else
                                            <a data-href="{{ route('role.unarchive', $contactentite->id) }}"
                                                style="cursor: pointer;"
                                                class="action-icon unarchive-role text-success"> <i
                                                    class="mdi mdi-archive-arrow-up"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
