Act as a senior product designer and UI/UX expert specializing in industrial SaaS dashboards, predictive systems, and data-heavy decision-support interfaces. Transform the provided low-fidelity wireframe into THREE high-fidelity, production-ready web app screens in Figma:

1. Main Dashboard  
2. Machine Management (list-based, with integrated settings panel)  
3. Energy Simulation (weather & battery impact)

All screens must share a consistent design system and feel like one cohesive industrial product.

---

PROJECT CONTEXT:

This is an Intelligent Energy Management System (IEMS) called "LoadSync", designed for industrial energy optimization using solar panels (PLTS), battery storage, and PLN backup.

The system supports:
- Real-time monitoring
- Machine control
- Forecasting
- Simulation
- Automated decision-making (load-shedding)

IMPORTANT:
This system is NOT just for monitoring — it actively controls and optimizes energy distribution across machines.

---

TARGET USERS:

- Industrial operators  
- Energy managers  
- Mid-scale manufacturing companies  

---

PRIMARY GOAL:

Enable fast, accurate, and confident decision-making based on real-time energy data, while allowing direct control and simulation of machine energy usage.

---

## 🎨 DESIGN PRINCIPLES

- Data clarity over decoration  
- High readability in dense environments  
- Strong visual hierarchy for fast scanning  
- Industrial, professional, modern aesthetic  
- Avoid unnecessary visual noise  
- Prioritize actionable UI (control + decision, not just display)  
- Emphasize cause → effect → action flow  

---

## 🎨 COLOR SYSTEM (SEMANTIC + INDUSTRIAL)

Dark / semi-dark theme:

- Background: #0F172A / #111827  
- Surface/Card: #1E293B  

Semantic colors:

- Green (#22C55E) → optimal  
- Yellow (#F59E0B) → warning  
- Red (#EF4444) → critical  
- Blue (#3B82F6) → informational  
- Gray (#94A3B8) → inactive  

Ensure WCAG contrast compliance.

---

## 🔤 TYPOGRAPHY

- Font: Inter / SF Pro / Manrope  
- Clean, modern, readable  

Hierarchy:
- Heading: 20–24px SemiBold  
- Subheading: 16–18px Medium  
- Body: 14–16px  
- Caption: 12–13px  

---

## 🧱 LAYOUT & GRID

- 12-column grid  
- 8px spacing system  
- Card-based layout  
- Border radius: 10–14px  
- Consistent alignment & spacing  

---

# 🖥️ SCREEN 1 — MAIN DASHBOARD (MONITOR + QUICK CONTROL)

### NAVBAR
- Logo (LoadSync)
- Weather & temperature
- System status (online/offline)
- Real-time clock
- Notification dropdown

---

### MAIN GRID

A. Energy Production (PLTS)
- kWh output
- Efficiency indicator
- Line/area chart

B. Battery Status
- Battery %
- Mode indicator
- Circular visualization

C. PLN Usage
- Threshold
- Backup activation
- Gauge/progress

D. System Status Summary
- PLTS / Battery / PLN

---

### SUPPLY vs DEMAND
- Horizontal stacked bar
- Supply (PLTS + PLN) vs Demand (Machines)

---

### DECISION SUPPORT SYSTEM (DSS)
- Smart recommendation cards:
  - Reduce PLN usage
  - Turn off low-priority machines
  - Switch to battery
- Include:
  - Priority color
  - Icon
  - Actionable text

---

### MACHINE PREVIEW LIST
- Compact table:
  - Machine Name
  - Priority
  - Status
  - Power Usage

---

### ACTIVITY LOG
- Timeline of events and system actions

---

# ⚙️ SCREEN 2 — MACHINE MANAGEMENT (CONTROL CENTER)

FOCUS: Direct control over machines using LIST (NOT CARD)

IMPORTANT:
- No separate pages per machine
- Use inline control + side drawer

---

### HEADER
- Title: Machine Management
- Subtitle: Control and prioritize machine energy usage
- Button: + Add Machine

---

### GLOBAL CONTROL BAR
- Auto Approve System (toggle)
- Mode:
  - Manual
  - Semi-auto
  - Full auto (DSS controlled)

- Summary:
  - Total machines
  - Active machines
  - Total energy usage

---

### MACHINE LIST TABLE (CORE)

Columns:
- Machine Name
- Power Usage (kW)
- Priority (dropdown)
- Status (toggle)
- Auto Approve (toggle)
- Actions (Edit / Delete)

REQUIREMENTS:
- Inline editing (no navigation)
- Fast interaction
- Color-coded priority & status

---

### SIDE DRAWER — ADD / EDIT MACHINE

Slide from right.

Fields:
- Machine Name
- Power Usage
- Priority
- Status
- Auto Approve

Optional:
- Critical machine flag
- Max runtime

Actions:
- Save / Cancel

---

# 🧪 SCREEN 3 — ENERGY SIMULATION (PREDICTION + WHAT-IF)

FOCUS: Cause → Effect → Decision

NOT a monitoring page.

---

### HEADER
- Title: Energy Simulation
- Subtitle: Simulate weather & battery impact
- Actions:
  - Run Simulation
  - Reset

---

### INPUT PANEL

Weather:
- Sunlight intensity (slider)
- Condition (sunny / cloudy / rainy)
- Temperature (optional)

Battery:
- Level (0–100%)
- Mode (normal / saving / emergency)

---

### SIMULATION OUTPUT

A. ENERGY SUPPLY CHANGE
- PLTS projection
- Battery usage
- PLN dependency
- Visual: before vs after

---

B. MACHINE IMPACT LIST

Columns:
- Machine Name
- Current Efficiency
- Predicted Efficiency
- Status Change (On / Reduced / Off)
- Priority

Highlight:
- Affected machines
- Load-shedding candidates

---

C. SYSTEM STATUS
- Stable / Warning / Critical

---

### DECISION SUPPORT OUTPUT

Cards:
- Turn off low-priority machines
- Switch to battery
- Reduce PLN usage
- Delay operations

Include:
- Priority
- Explanation
- Suggested action

---

### VISUAL FLOW

Must clearly show:

INPUT → SIMULATION → IMPACT → DECISION

---

## ⚙️ INTERACTIONS

- Hover → elevation
- Toggle → smooth animation
- Drawer → slide from right
- Simulation → dynamic update
- Tooltip → explain metrics

---

## ✨ VISUAL STYLE

- Industrial, minimal, clean
- Dark UI + semantic accents
- No clutter
- No decorative elements
- No carousel

---

## 📏 DETAIL REQUIREMENTS

- Strict 8px spacing system
- Proper alignment
- Realistic industrial dummy data
- Clear before vs after comparison

---

## ♿ ACCESSIBILITY

- WCAG compliant
- Do not rely only on color
- Clear labeling

---

## 🚫 IMPORTANT CONSTRAINTS

- Do NOT make generic SaaS UI
- Do NOT overuse charts
- Maintain industrial + energy context
- Focus on decision-making, not decoration

---

## 🎯 OUTPUT

- 3 complete high-fidelity screens:
  1. Dashboard
  2. Machine Management (list-based)
  3. Simulation

- Unified design system
- Developer-ready UI
- Suitable for real industrial deployment