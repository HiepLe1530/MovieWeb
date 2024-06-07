<div>
    <div class="mt-2">
        <form method="GET" class="d-flex" role="search">
            <div class="form-group" style="margin-right: 10px">
                <label for="">Tên người dùng</label>
                <input wire:model.live.debounce.500ms="userName" class="form-control" type="search" name="" placeholder="Tên người dùng" aria-label="Search"  value="" >
                
            </div>
            <div class=" form-group" style="margin-right: 10px">
                <label for="">Email</label>
                <input wire:model.live.debounce.500ms="email" class="form-control" type="search" name="title" placeholder="Email" aria-label="Search"  value="">
                
            </div>
            <div class="form-group">
                <label for="">Vai trò</label>
                <select wire:model.live.debounce.500ms="userRole" class="form-control" name="" id="">
                    <option value="0">Chọn vai trò</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->r_Name }}</option>
                    @endforeach
                </select>
                
            </div>
            
        </form>
        
    </div>
    <table class="table-secondary mt-3 w-100">
        <thead style="border: 1px solid black">
            <tr>
                <th class="col-1">#</th>
                <th class="col-3">Ảnh đại diện</th>
                <th class="col-3">Tên người dùng</th>
                <th class="col-3">Email</th>
                <th class="col-2">Vai trò</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @if (!empty($users))
                @foreach ($users as $item)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td><img src="/images/{{ $item->u_Avatar }}" width="80px" alt=""></td>
                        <td>{{ $item->u_UserName }}</td>
                        <td>{{ $item->u_Email }}</td>
                        @if (Auth::id() == $item->id)
                            @foreach ($roles as $role)
                                @if ($role->id == $item->u_r_id)
                                    <td>{{ $role->r_Name }}</td>
                                    @break
                                @endif
                            @endforeach
                        @else
                            <td>
                                <select name="" id="role_{{ $item->id }}" data-user_id="{{ $item->id }}" data-role_id="{{ $item->u_r_id }}" onchange="updateRole(this, {{ $item->id }})">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $item->u_r_id ? 'selected' : '' }}>{{ $role->r_Name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                    </tr>
                @endforeach
                
            @else
                <tr>
                    <td colspan="6">{{ $norecord }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{-- <div class="d-flex justify-content-end mt-3">
        {{ $users->links() }}
    </div> --}}
</div>
