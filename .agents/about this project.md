system:
  name: LoadSync IEMS
  type: Intelligent Energy Management System
  description: >
    Web-based system for monitoring, controlling, and optimizing industrial energy usage
    using solar panels (PLTS), battery storage, and PLN backup.
    The system includes real-time monitoring, machine control, forecasting, and simulation.

---

core_concepts:
  - real_time_monitoring
  - machine_control
  - load_shedding
  - decision_support_system
  - simulation_engine

---

entities:

  machine:
    description: Industrial machine consuming energy
    fields:
      id: uuid
      name: string
      power_usage_kw: float
      priority: enum [high, medium, low]
      status: enum [on, off]
      auto_approve: boolean
      is_critical: boolean
      created_at: datetime
      updated_at: datetime

  energy_source:
    description: Source of energy
    fields:
      id: uuid
      type: enum [plts, battery, pln]
      current_output_kw: float
      max_capacity_kw: float
      status: enum [active, inactive]

  battery:
    description: Battery storage system
    fields:
      id: uuid
      capacity_kwh: float
      current_level_percent: float
      mode: enum [normal, saving, emergency]
      charge_rate: float
      discharge_rate: float

  weather:
    description: Weather data affecting solar production
    fields:
      id: uuid
      condition: enum [sunny, cloudy, rainy]
      sunlight_intensity: float
      temperature: float
      timestamp: datetime

  system_status:
    description: Overall system state
    fields:
      total_supply_kw: float
      total_demand_kw: float
      system_health: enum [stable, warning, critical]

  recommendation:
    description: DSS output
    fields:
      id: uuid
      type: enum [reduce_pln, switch_battery, shutdown_machine, delay_operation]
      priority: enum [high, medium, low]
      message: string
      affected_machine_ids: list<uuid>
      created_at: datetime

  activity_log:
    description: System events
    fields:
      id: uuid
      type: string
      message: string
      timestamp: datetime

---

features:

  dashboard:
    description: Real-time monitoring dashboard
    components:
      - energy_production_plts
      - battery_status
      - pln_usage
      - supply_vs_demand
      - decision_support_cards
      - machine_preview_list
      - activity_log

    logic:
      energy_production:
        formula: >
          plts_output = weather.sunlight_intensity * efficiency_factor

      supply_demand:
        formula: >
          total_supply = plts_output + battery_discharge + pln_usage
          total_demand = sum(machine.power_usage_kw where status = on)

      system_health:
        rules:
          - if total_supply >= total_demand: stable
          - if total_supply slightly < demand: warning
          - if total_supply << demand: critical

---

  machine_management:
    description: Manage and control machines using LIST (not card)
    
    ui_structure:
      type: table_list
      columns:
        - machine_name
        - power_usage_kw
        - priority
        - status
        - auto_approve
        - actions

    global_controls:
      auto_approve_system: boolean
      mode: enum [manual, semi_auto, full_auto]

    behaviors:
      toggle_status:
        description: Turn machine ON/OFF
        effect:
          - updates total_demand
          - may trigger recommendation recalculation

      change_priority:
        description: Update machine priority
        effect:
          - affects load shedding order

      auto_approve:
        description: Allow system to control machine automatically

    load_shedding_logic:
      description: Turn off machines when supply is insufficient
      steps:
        - sort machines by priority ascending (low → high)
        - turn off lowest priority machines first
        - skip machines with is_critical = true
        - skip machines with auto_approve = false (unless forced mode)

---

  simulation:
    description: Simulate weather and battery impact on system
    
    inputs:
      weather:
        sunlight_intensity: float
        condition: enum [sunny, cloudy, rainy]
        temperature: float

      battery:
        level_percent: float
        mode: enum [normal, saving, emergency]

    processing:

      plts_projection:
        formula: >
          projected_plts = sunlight_intensity * efficiency_factor

      battery_behavior:
        rules:
          - normal: balanced charge/discharge
          - saving: reduce discharge
          - emergency: maximize discharge

      demand_projection:
        formula: >
          projected_demand = sum(active machines)

      system_balance:
        formula: >
          balance = projected_supply - projected_demand

    outputs:

      energy_projection:
        - plts_output
        - battery_usage
        - pln_dependency

      machine_impact:
        description: Effect on each machine
        fields:
          - machine_id
          - current_efficiency
          - predicted_efficiency
          - status_change

      system_status:
        - stable
        - warning
        - critical

      recommendations:
        generated_based_on:
          - supply_demand_gap
          - battery_level
          - machine_priority

---

decision_support_system:

  rules:

    - condition: supply < demand
      action: shutdown_low_priority_machines

    - condition: battery_level > 60%
      action: switch_to_battery

    - condition: plts_output_high
      action: reduce_pln_usage

    - condition: battery_level < 20%
      action: activate_saving_mode

---

api_design:

  machine:
    - GET /machines
    - POST /machines
    - PUT /machines/{id}
    - DELETE /machines/{id}
    - PATCH /machines/{id}/toggle
    - PATCH /machines/{id}/priority

  dashboard:
    - GET /dashboard/summary
    - GET /dashboard/energy
    - GET /dashboard/logs

  simulation:
    - POST /simulation/run
    - GET /simulation/result

---

data_flow:

  - user updates machine settings
  - system recalculates demand
  - system evaluates supply vs demand
  - DSS generates recommendation
  - UI updates in real-time

---

constraints:

  - must support real-time updates
  - must handle multiple machines
  - must prioritize system stability
  - must avoid turning off critical machines

---

non_functional_requirements:

  performance:
    - real-time updates < 1 second

  scalability:
    - support 100+ machines

  reliability:
    - fail-safe when data missing

  usability:
    - minimal user interaction required