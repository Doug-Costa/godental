<script>
    // Global variable to hold current doctor being edited
    let currentDoctor = null;

    function openDoctorModal() {
        currentDoctor = null;
        document.getElementById('doctorId').value = '';
        document.getElementById('modalDoctorTitle').innerText = 'Novo Profissional';

        // Reset inputs
        document.getElementById('doctorName').value = '';
        document.getElementById('doctorRole').value = 'dentist';
        document.getElementById('doctorSpecialty').value = '';
        document.getElementById('doctorCrm').value = '';
        document.getElementById('doctorPhone').value = '';
        document.getElementById('doctorEmail').value = '';
        document.getElementById('doctorColor').value = '#CA1D53';

        document.getElementById('doctorContractType').value = '';
        document.getElementById('doctorRemunerationType').value = '';
        document.getElementById('doctorFixedSalary').value = '';
        document.getElementById('doctorCommission').value = '';
        document.getElementById('doctorPixKey').value = '';
        document.getElementById('doctorBankDetails').value = '';

        // Reset Schedule
        document.getElementById('scheduleList').innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Salve o profissional antes de adicionar horários</td></tr>';
        // Disable schedule inputs if creating new
        toggleScheduleInputs(false);

        new bootstrap.Modal(document.getElementById('modalDoctor')).show();
    }

    function editDoctor(doctor) {
        currentDoctor = doctor;
        document.getElementById('doctorId').value = doctor.id;
        document.getElementById('modalDoctorTitle').innerText = 'Editar Profissional';

        document.getElementById('doctorName').value = doctor.name;
        document.getElementById('doctorRole').value = doctor.role || 'dentist';
        document.getElementById('doctorSpecialty').value = doctor.specialty || '';
        document.getElementById('doctorCrm').value = doctor.crm || '';
        document.getElementById('doctorPhone').value = doctor.phone || '';
        document.getElementById('doctorEmail').value = doctor.email || '';
        document.getElementById('doctorColor').value = doctor.color || '#CA1D53';

        document.getElementById('doctorContractType').value = doctor.contract_type || '';
        document.getElementById('doctorRemunerationType').value = doctor.remuneration_type || '';
        document.getElementById('doctorFixedSalary').value = doctor.fixed_salary || '';
        document.getElementById('doctorCommission').value = doctor.commission_percentage || '';
        document.getElementById('doctorPixKey').value = doctor.pix_key || '';
        document.getElementById('doctorBankDetails').value = doctor.bank_details || '';

        // Schedule
        renderScheduleList(doctor.schedule_slots || []);
        toggleScheduleInputs(true);

        new bootstrap.Modal(document.getElementById('modalDoctor')).show();
    }

    function saveDoctor() {
        const id = document.getElementById('doctorId').value;
        const url = id ? `/api/admin/doctors/${id}` : '/api/admin/doctors';
        const method = id ? 'PUT' : 'POST';

        const getVal = (id) => {
            const val = document.getElementById(id).value;
            return val === '' ? null : val;
        };

        const data = {
            name: document.getElementById('doctorName').value,
            role: getVal('doctorRole'),
            specialty: getVal('doctorSpecialty'),
            crm: getVal('doctorCrm'),
            phone: getVal('doctorPhone'),
            email: getVal('doctorEmail'),
            color: getVal('doctorColor'),

            contract_type: getVal('doctorContractType'),
            remuneration_type: getVal('doctorRemunerationType'),
            fixed_salary: getVal('doctorFixedSalary'),
            commission_percentage: getVal('doctorCommission'),
            pix_key: getVal('doctorPixKey'),
            bank_details: getVal('doctorBankDetails'),
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro ao salvar: ' + (data.message || JSON.stringify(data.errors)));
                }
            })
            .catch(err => alert('Erro: ' + err));
    }

    function deleteDoctor(id) {
        if (!confirm('Tem certeza que deseja excluir este profissional?')) return;

        fetch(`/api/admin/doctors/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) location.reload();
                else alert('Erro ao excluir');
            });
    }

    // Schedule Functions
    function toggleScheduleInputs(enable) {
        const inputs = ['scheduleDay', 'scheduleStart', 'scheduleEnd', 'scheduleDuration'];
        inputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.disabled = !enable;
        });
        // Also the add button
        const btn = document.querySelector('button[onclick="addSchedule()"]');
        if (btn) btn.disabled = !enable;
    }

    function renderScheduleList(slots) {
        const tbody = document.getElementById('scheduleList');
        if (!tbody) return;
        tbody.innerHTML = '';

        if (!slots || slots.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Nenhum horário configurado</td></tr>';
            return;
        }

        const days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];

        slots.forEach(slot => {
            const row = `
                <tr>
                    <td>${days[slot.day_of_week] || 'Dia ' + slot.day_of_week}</td>
                    <td>${slot.start_time.substring(0, 5)} - ${slot.end_time.substring(0, 5)}</td>
                    <td>${slot.slot_duration} min</td>
                    <td class="text-end">
                        <button class="btn btn-link text-danger p-0" onclick="deleteSchedule(${slot.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    function addSchedule() {
        if (!currentDoctor) {
            alert('Salve o profissional primeiro.');
            return;
        }

        const data = {
            doctor_id: currentDoctor.id,
            day_of_week: document.getElementById('scheduleDay').value,
            start_time: document.getElementById('scheduleStart').value,
            end_time: document.getElementById('scheduleEnd').value,
            slot_duration: document.getElementById('scheduleDuration').value
        };

        if (!data.start_time || !data.end_time) {
            alert('Preencha os horários de início e fim.');
            return;
        }

        fetch('/api/admin/doctor-schedules', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    // Add to current doctor slots and re-render
                    if (!currentDoctor.schedule_slots) currentDoctor.schedule_slots = [];
                    currentDoctor.schedule_slots.push(res.schedule);
                    // Sort by day and time
                    currentDoctor.schedule_slots.sort((a, b) => a.day_of_week - b.day_of_week || a.start_time.localeCompare(b.start_time));
                    renderScheduleList(currentDoctor.schedule_slots);
                } else {
                    alert('Erro ao adicionar horário: ' + (JSON.stringify(res.errors) || res.message));
                }
            })
            .catch(err => alert('Erro: ' + err));
    }

    function deleteSchedule(id) {
        if (!confirm('Remover este horário?')) return;

        fetch(`/api/admin/doctor-schedules/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    // Remove from local array
                    currentDoctor.schedule_slots = currentDoctor.schedule_slots.filter(s => s.id !== id);
                    renderScheduleList(currentDoctor.schedule_slots);
                } else {
                    alert('Erro ao remover.');
                }
            })
            .catch(err => alert('Erro: ' + err));
    }

    // ─── SERVICE PRICE FUNCTIONS ───

    function openPriceModal() {
        document.getElementById('priceId').value = '';
        document.getElementById('modalPriceTitle').innerText = 'Novo Serviço';
        document.getElementById('priceName').value = '';
        document.getElementById('priceCategory').value = 'Procedimento';
        document.getElementById('priceDefault').value = '';
        document.getElementById('priceActive').checked = true;
        new bootstrap.Modal(document.getElementById('modalServicePrice')).show();
    }

    function editPrice(price) {
        document.getElementById('priceId').value = price.id;
        document.getElementById('modalPriceTitle').innerText = 'Editar Serviço';
        document.getElementById('priceName').value = price.name;
        document.getElementById('priceCategory').value = price.category;
        document.getElementById('priceDefault').value = price.default_price;
        document.getElementById('priceActive').checked = price.is_active;
        new bootstrap.Modal(document.getElementById('modalServicePrice')).show();
    }

    function savePrice() {
        const id = document.getElementById('priceId').value;
        const url = id ? `/api/admin/service-prices/${id}` : '/api/admin/service-prices';
        const method = id ? 'PUT' : 'POST';

        const data = {
            name: document.getElementById('priceName').value,
            category: document.getElementById('priceCategory').value,
            default_price: document.getElementById('priceDefault').value,
            is_active: document.getElementById('priceActive').checked ? 1 : 0
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) location.reload();
                else alert('Erro ao salvar serviço: ' + (data.message || JSON.stringify(data.errors)));
            })
            .catch(err => alert('Erro: ' + err));
    }

    function deletePrice(id) {
        if (!confirm('Excluir este serviço?')) return;
        fetch(`/api/admin/service-prices/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(res => res.json()).then(data => {
            if (data.success) location.reload();
            else alert('Erro ao excluir');
        });
    }

    // ─── INVENTORY FUNCTIONS ───

    function openInventoryModal() {
        document.getElementById('itemId').value = '';
        document.getElementById('modalInventoryTitle').innerText = 'Novo Item';
        document.getElementById('itemName').value = '';
        document.getElementById('itemUnit').value = '';
        document.getElementById('itemMinStock').value = '5';
        document.getElementById('itemCost').value = '';
        document.getElementById('itemSelling').value = '';
        document.getElementById('itemSupplier').value = '';
        document.getElementById('initialStockAlert').classList.remove('d-none'); // Show alert for new items
        new bootstrap.Modal(document.getElementById('modalInventory')).show();
    }

    function editInventory(item) {
        document.getElementById('itemId').value = item.id;
        document.getElementById('modalInventoryTitle').innerText = 'Editar Item';
        document.getElementById('itemName').value = item.name;
        document.getElementById('itemUnit').value = item.unit;
        document.getElementById('itemMinStock').value = item.min_stock;
        document.getElementById('itemCost').value = item.cost_price;
        document.getElementById('itemSelling').value = item.selling_price;
        document.getElementById('itemSupplier').value = item.supplier_id || '';
        document.getElementById('initialStockAlert').classList.add('d-none'); // Hide alert for edit
        new bootstrap.Modal(document.getElementById('modalInventory')).show();
    }

    function saveInventory() {
        const id = document.getElementById('itemId').value;
        const url = id ? `/inventory/${id}` : '/inventory';
        const method = id ? 'PUT' : 'POST';

        const data = {
            name: document.getElementById('itemName').value,
            unit: document.getElementById('itemUnit').value,
            min_stock: document.getElementById('itemMinStock').value,
            cost_price: document.getElementById('itemCost').value,
            selling_price: document.getElementById('itemSelling').value,
            supplier_id: document.getElementById('itemSupplier').value || null,
            // For create, we might send current_stock=0 explicitly if needed, but DB default is probably 0
            current_stock: 0
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // If it was a create, user might want to add stock immediately, but reload is safer for now
                    location.reload();
                } else {
                    alert('Erro ao salvar item: ' + (data.message || JSON.stringify(data.errors)));
                }
            })
            .catch(err => alert('Erro: ' + err));
    }

    function deleteInventory(id) {
        if (!confirm('Excluir este item do estoque?')) return;
        fetch(`/inventory/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(res => res.json()).then(data => {
            if (data.success) location.reload();
            else alert('Erro ao excluir');
        });
    }

    // Stock Entry
    function openStockEntryModal(item) {
        document.getElementById('entryItemId').value = item.id;
        document.getElementById('entryItemName').innerText = item.name;
        document.getElementById('entryQuantity').value = '';
        document.getElementById('entryCost').value = item.cost_price;
        document.getElementById('entryCreateExpense').checked = true;
        document.getElementById('expenseFields').classList.remove('d-none');
        new bootstrap.Modal(document.getElementById('modalStockEntry')).show();
    }

    function saveStockEntry() {
        const id = document.getElementById('entryItemId').value;
        const url = `/inventory/${id}/stock`; // matches stockEntry route

        const data = {
            quantity: document.getElementById('entryQuantity').value,
            cost_price: document.getElementById('entryCost').value,
            create_expense: document.getElementById('entryCreateExpense').checked ? 1 : 0,
            expense_category_id: document.getElementById('entryCategory').value,
            expense_description: document.getElementById('entryDescription').value
        };

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) location.reload();
                else alert('Erro ao dar entrada: ' + (data.message || JSON.stringify(data.errors)));
            })
            .catch(err => alert('Erro: ' + err));
    }
</script>