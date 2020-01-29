@extends('layouts.app')
@push('styles')
    <style>
        #hot-display-license-info {
            display: none;
        }

        .spreadsheets {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 576px) {
            .spreadsheets {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .spreadsheets {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .spreadsheets {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .spreadsheets {
                max-width: 1140px;
            }
        }

        .spreadsheets-fluid,
        .spreadsheets-xl,
        .spreadsheets-lg,
        .spreadsheets-md,
        .spreadsheets-sm {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 576px) {
            .spreadsheets-sm,
            .spreadsheets {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .spreadsheets-md,
            .spreadsheets-sm,
            .spreadsheets {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .spreadsheets-lg,
            .spreadsheets-md,
            .spreadsheets-sm,
            .spreadsheets {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .spreadsheets-xl,
            .spreadsheets-lg,
            .spreadsheets-md,
            .spreadsheets-sm,
            .spreadsheets {
                max-width: 1140px;
            }
        }


    </style>
@endpush
@section('content')
      <!-- Grid container -->
  <div class="container my-5">

    <!--Grid row-->
    <div class="row d-flex justify-content-center">
       
        <!-- Editable table -->




        <div class="card spreadsheets h-100 min-vh-100">
            <h3 class="card-header text-center font-weight-bold text-uppercase py-4"></h3>
            <div class="card-body overflow-hidden spreadsheets p-5">
                <div id="table" class="table-editable">
        <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i
                    class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
                    <button v-if="!isAuthenticated" @click="signin" class="btn btn-primary">Entrar</button>
                    <button v-if="isAuthenticated" @click="updateSheet" class="btn btn-primary">Actualizar</button>
                    <table class="table table-bordered table-responsive-md table-striped text-center">
                        <thead>
                        <tr>
                            <th class="text-center">A</th>
                            <th class="text-center">B</th>
                            <th class="text-center">C</th>
                            <th class="text-center">D</th>
                        </tr>
                        </thead>
                        <tbody>

                        @for ($row = 0; $row < 100; $row++)
                            <tr>
                                @for ($col = 0; $col <4; $col++)
                                    <td class="pt-3-half" contenteditable="true">
                                        <input class="form-control" type='text'  name="{{ $row.':'.$col }}" id="{{ $row.':'.$col }}">
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Editable table -->

    </div>
    <!--Grid row-->


  </div>
  <!-- Grid container -->
@endsection

@push('scripts')

    <script>

        const app = new Vue({
            el: '#app',

            data() {
                return {
                    ssID: "1nVpbFQY9HYDI5YWxhP0z0xMNeefC3dsr_bgbxIc8uL0",
                    rng: "Demo",
                    data: [],
                    hotSettings: {
                        contextMenu: {
                            items: {
                                'row_above': {
                                    name: 'Insert row above this one (custom name)'
                                },
                                'stretchH': 'all',
                                'row_below': {},
                                'separator':  '|',
                                colHeaders: true,
                                'clear_custom': {
                                    name: 'Clear all cells (custom)',
                                    callback: function() {
                                        this.clear();
                                    }
                                }
                            }
                        }
                    },
                    className: 'spreadsheets',
                    fields: { A: "A", B: "B" },
                    items: [{ name: "Joe", age: 33 }, { name: "Sue", age: 77 }],

                }
            },
            computed: {
                isAuthenticated () {
                    return this.$gapi.isAuthenticated()
                }
            },

            mounted() {
                const params = {
                    spreadsheetId: this.ssID,
                    range: this.rng,
                    majorDimension: "ROWS"
                }

               this.getClients(params)
            },
            methods: {
                signin () {
                    if (this.$gapi.isAuthenticated() !== true) {
                        this.$gapi.login()
                    }
                },
                signout () {
                    this.$gapi.logout()
                },
                populateSheet(result) {
                    var results = "";
                    for(var row=0; row<100; row++) {
                        for(var col=0; col<4; col++) {
                            document.getElementById(row+":"+col).value = result.values[row][col];
                        }
                    }
                },
                getClients (params) {
                    _this = this;
                    this.$gapi.getGapiClient().then((gapi) => {
                        var request = gapi.client.sheets.spreadsheets.values.get(params);
                        request.then(function(response) {
                        // TODO: Change code below to process the `response` object:
                            _this.data = response.result.values
                            _this.populateSheet(response.result)

                        }, function(reason) {
                            console.error('error: ' + reason.result.error.message);
                        });
                    })
                }, 

                updateSheet() {
                    let vals = new Array(100);
                    for (let row = 0; row < 100; row++){
                        vals[row] = new Array(4);
                        for (let col = 0; col < 4; col++){
                            vals[row][col] = document.getElementById(row+":"+col).value;
                        }
                    }

                    const params = {
                        spreadsheetId: this.ssID,
                        range: this.rng,
                        valueInputOption: "RAW"
                    }

                    let valueRangeBody = { "values": vals}
                    this.$gapi.getGapiClient().then((gapi) => {
                        var request = gapi.client.sheets.spreadsheets.values.update(params, valueRangeBody);
                        request.then(function(response) {
                            console.log(response.result);
                        }, function(reason) {
                            console.error('error: ' + reason.result.error.message);
                        });
                    })
                    
                },
            },
        });
    </script>
@endpush
