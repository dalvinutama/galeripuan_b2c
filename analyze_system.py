"""
ANALISIS ARSITEKTUR GALLERY PUAN.ID
Skrip ini hanya mendeteksi komponen yang BENAR-BENAR ADA di sistem ini.
Tidak ada tebakan / default generic.
"""

import os
import json
import re

PROJECT = r"C:\xampp\htdocs\gallery-puan"


def tech_stack_actual(root):
    """Deteksi tech stack hanya dari file yang benar-benar ada."""
    stack = {
        "language": "PHP ^8.1",
        "framework": "Laravel 10",
        "database": "MySQL (gallery-puandb)",
        "auth_guards": [],
        "packages_backend": [],
        "packages_frontend": [],
        "third_party_services": [],
    }

    # composer.json
    with open(os.path.join(root, "composer.json")) as f:
        req = json.load(f).get("require", {})

    pkg_map = {
        "livewire/livewire": "Laravel Livewire 4.2 (komponen interaktif tanpa JS)",
        "nwidart/laravel-modules": "nwidart/laravel-modules 10.0 (modular HMVC)",
        "midtrans/midtrans-php": "Midtrans PHP SDK 2.6 (payment gateway)",
        "pusher/pusher-php-server": "Pusher PHP Server 7.2 (WebSocket backend)",
        "spatie/laravel-medialibrary": "Spatie Media Library 11 (manajemen gambar)",
        "spatie/laravel-html": "Spatie Laravel HTML 3 (HTML helper)",
        "barryvdh/laravel-dompdf": "Barryvdh DomPDF 3 (export PDF laporan)",
        "guzzlehttp/guzzle": "GuzzleHttp 7 (HTTP client RajaOngkir)",
        "laravel/sanctum": "Laravel Sanctum 3 (API token auth)",
        "laravel/tinker": "Laravel Tinker 2 (REPL artisan)",
        "laravel/ui": "Laravel UI 4 (Bootstrap scaffolding)",
    }
    for pkg, desc in pkg_map.items():
        if pkg in req:
            stack["packages_backend"].append(desc)

    # package.json
    with open(os.path.join(root, "package.json")) as f:
        pkg_data = json.load(f)
    deps = {**pkg_data.get("dependencies", {}), **pkg_data.get("devDependencies", {})}

    front_map = {
        "bootstrap": "Bootstrap 5.2 (CSS framework)",
        "jquery": "jQuery 4.0 (DOM manipulasi)",
        "laravel-echo": "Laravel Echo 1.16 (Pusher client-side)",
        "pusher-js": "Pusher JS 8.4 (WebSocket client)",
        "axios": "Axios 1.1 (HTTP client AJAX)",
        "vite": "Vite 4 + laravel-vite-plugin 0.7 (bundler)",
        "sass": "Sass 1.56 (CSS preprocessor)",
        "@popperjs/core": "PopperJS 2.11 (tooltip/positioning)",
    }
    for pkg, desc in front_map.items():
        if any(pkg in k for k in deps):
            stack["packages_frontend"].append(desc)

    # .env service detection
    env_path = os.path.join(root, ".env")
    if os.path.exists(env_path):
        with open(env_path) as f:
            env_content = f.read()
        if "MIDTRANS_MERCHANT_ID" in env_content:
            stack["third_party_services"].append(
                "Midtrans Payment Gateway (kartu kredit, VA, QRIS, convenience store, transfer bank)"
            )
        if "PUSHER_APP_ID" in env_content:
            stack["third_party_services"].append(
                "Pusher WebSocket (live chat real-time customer-admin)"
            )
        if "MAIL_MAILER" in env_content and "smtp" in env_content.split("MAIL_MAILER")[1].split("\n")[0].lower():
            stack["third_party_services"].append(
                "SMTP Mail Server (notifikasi email after-sales)"
            )

    # Guard detection
    auth_path = os.path.join(root, "config", "auth.php")
    if os.path.exists(auth_path):
        with open(auth_path) as f:
            c = f.read()
        if "'admin'" in c:
            stack["auth_guards"].append("web -> User (uuid) untuk konsumen")
            stack["auth_guards"].append("admin -> Admin (bigint) untuk dashboard")

    return stack


def scan_admin_livewire(root):
    """Scan semua Livewire component admin."""
    components = []
    base = os.path.join(root, "app", "Livewire", "Admin")
    for dirpath, _, files in os.walk(base):
        for f in files:
            if f.endswith(".php"):
                rel = os.path.relpath(os.path.join(dirpath, f), base)
                name = rel.replace(".php", "").replace("\\", "/")
                components.append(name)
    return sorted(components)


def scan_customer_controllers(root):
    """Scan semua controller customer di module Shop."""
    controllers = []
    base = os.path.join(root, "Modules", "Shop", "Http", "Controllers")
    for f in os.listdir(base):
        if f.endswith(".php") and f not in (".gitkeep", "ShopController.php"):
            path = os.path.join(base, f)
            with open(path, encoding="utf-8") as fh:
                content = fh.read()
            methods = re.findall(r"public function (\w+)\([^)]*\)", content)
            controllers.append(
                {
                    "file": f.replace(".php", "").replace("Controller", ""),
                    "methods": methods,
                }
            )
    return controllers


def scan_models(root):
    """Scan semua model dari kedua lokasi."""
    models = []
    for base_dir, label in [
        (os.path.join(root, "app", "Models"), "App\\Models"),
        (os.path.join(root, "Modules", "Shop", "Entities"), "Modules\\Shop\\Entities"),
    ]:
        for f in sorted(os.listdir(base_dir)):
            if f.endswith(".php") and f != ".gitkeep":
                path = os.path.join(base_dir, f)
                with open(path, encoding="utf-8") as fh:
                    content = fh.read()
                relations = re.findall(
                    r"function (\w+)\(\)\s*:\s*(Belongs|Has|Morph)", content
                )
                models.append(
                    {
                        "class": f"{label}\\{f.replace('.php', '')}",
                        "relations": [r[0] for r in relations],
                    }
                )
    return models


def scan_mail(root):
    """Scan semua mail class."""
    mails = []
    base = os.path.join(root, "app", "Mail")
    for f in sorted(os.listdir(base)):
        if f.endswith(".php"):
            mails.append(f.replace(".php", ""))
    return mails


def scan_observers_listeners_commands(root):
    """Scan observers, listeners, commands."""
    result = {"observers": [], "listeners": [], "commands": []}
    base = os.path.join(root, "app", "Observers")
    for f in sorted(os.listdir(base)):
        if f.endswith(".php"):
            result["observers"].append(f.replace(".php", ""))
    base = os.path.join(root, "app", "Listeners")
    for f in sorted(os.listdir(base)):
        if f.endswith(".php"):
            result["listeners"].append(f.replace(".php", ""))
    base = os.path.join(root, "app", "Console", "Commands")
    for f in sorted(os.listdir(base)):
        if f.endswith(".php"):
            result["commands"].append(f.replace(".php", ""))
    return result


def scan_frontend_livewire(root):
    """Scan Livewire frontend components."""
    front = []
    base = os.path.join(root, "app", "Livewire", "Front")
    if os.path.exists(base):
        for f in sorted(os.listdir(base)):
            if f.endswith(".php"):
                front.append(f.replace(".php", ""))
    return front


def scan_migrations(root):
    """Hitung migration files."""
    total = 0
    for d in [
        os.path.join(root, "database", "migrations"),
        os.path.join(root, "Modules", "Shop", "Database", "Migrations"),
    ]:
        if os.path.exists(d):
            total += len([f for f in os.listdir(d) if f.endswith(".php")])
    return total


def scan_customer_views(root):
    """Scan view files customer."""
    views = []
    theme = os.path.join(root, "resources", "views", "themes", "gallerypuan")
    if os.path.exists(theme):
        for f in sorted(os.listdir(theme)):
            fp = os.path.join(theme, f)
            if os.path.isdir(fp):
                blade = [x for x in os.listdir(fp) if x.endswith(".blade.php")]
                views.append(f"{f}/ ({len(blade)} file)")
            elif f.endswith(".blade.php"):
                views.append(f)
    return views


# ============================================================
# EXECUTION
# ============================================================

stack = tech_stack_actual(PROJECT)
admin_lw = scan_admin_livewire(PROJECT)
customer_ctrl = scan_customer_controllers(PROJECT)
models = scan_models(PROJECT)
mails = scan_mail(PROJECT)
infra = scan_observers_listeners_commands(PROJECT)
front_lw = scan_frontend_livewire(PROJECT)
mig_count = scan_migrations(PROJECT)
views = scan_customer_views(PROJECT)

print("=" * 60)
print("  ANALISIS ARSITEKTUR GALLERY PUAN.ID")
print("  (hanya komponen yang benar-benar ada)")
print("=" * 60)

print("\n1. TECH STACK")
print(f"   Bahasa: {stack['language']}")
print(f"   Framework: {stack['framework']}")
print(f"   Database: {stack['database']}")
print(f"   Auth Guards:")
for g in stack["auth_guards"]:
    print(f"     - {g}")

print(f"\n   Backend Packages ({len(stack['packages_backend'])}):")
for p in stack["packages_backend"]:
    print(f"     - {p}")

print(f"\n   Frontend Packages ({len(stack['packages_frontend'])}):")
for p in stack["packages_frontend"]:
    print(f"     - {p}")

print(f"\n   Third-Party Services ({len(stack['third_party_services'])}):")
for s in stack["third_party_services"]:
    print(f"     - {s}")

print(f"\n2. ADMIN LIVEWIRE COMPONENTS ({len(admin_lw)})")
for c in admin_lw:
    print(f"   - {c}")

print(f"\n3. CUSTOMER CONTROLLERS ({len(customer_ctrl)})")
for c in customer_ctrl:
    print(f"   - {c['file']}Controller ({len(c['methods'])} method)")
    for m in c["methods"]:
        print(f"       > {m}()")

print(f"\n4. MODELS ({len(models)})")
for m in models:
    rel_str = ", ".join(m["relations"]) if m["relations"] else "(tanpa relasi explicit)"
    print(f"   - {m['class']}  [{rel_str}]")

print(f"\n5. MAIL CLASSES ({len(mails)})")
for m in mails:
    print(f"   - {m}")

print(f"\n6. OBSERVERS / LISTENERS / COMMANDS")
print(f"   Observers ({len(infra['observers'])}):")
for o in infra["observers"]:
    print(f"     - {o}")
print(f"   Listeners ({len(infra['listeners'])}):")
for l in infra["listeners"]:
    print(f"     - {l}")
print(f"   Console Commands ({len(infra['commands'])}):")
for c in infra["commands"]:
    print(f"     - {c}")

print(f"\n7. FRONTEND LIVEWIRE ({len(front_lw)})")
for f in front_lw:
    print(f"   - {f}")

print(f"\n8. CUSTOMER VIEWS ({len(views)})")
for v in views:
    print(f"   - {v}")

print(f"\n9. MIGRATION FILES: {mig_count}")

# Routes
route_files = [
    os.path.join(PROJECT, "routes", "web.php"),
    os.path.join(PROJECT, "Modules", "Shop", "Routes", "web.php"),
]
print(f"\n10. ROUTE DEFINITIONS:")
for rf in route_files:
    if os.path.exists(rf):
        with open(rf, encoding="utf-8") as f:
            content = f.read()
        all_routes = re.findall(r"Route::\w+\(['\"]([^'\"]+)", content)
        gets = re.findall(r"Route::get\(['\"]([^'\"]+)", content)
        posts = re.findall(r"Route::post\(['\"]([^'\"]+)", content)
        puts = re.findall(r"Route::put\(['\"]([^'\"]+)", content)
        deletes = re.findall(r"Route::delete\(['\"]([^'\"]+)", content)
        label = rf.replace(PROJECT, "").lstrip("\\/")
        print(
            f"   {label}: {len(all_routes)} total (GET:{len(gets)} POST:{len(posts)} PUT:{len(puts)} DELETE:{len(deletes)})"
        )

print(f"\n11. TOTAL KOMPONEN SISTEM:")
print(f"    Admin Livewire Components : {len(admin_lw)}")
print(f"    Customer Controllers      : {len(customer_ctrl)}")
print(f"    Frontend Livewire         : {len(front_lw)}")
print(f"    Models                    : {len(models)}")
print(f"    Mail Classes              : {len(mails)}")
print(f"    Observers                 : {len(infra['observers'])}")
print(f"    Listeners                 : {len(infra['listeners'])}")
print(f"    Console Commands          : {len(infra['commands'])}")
print(f"    Migration Files           : {mig_count}")
print(f"    Customer View Files       : {len(views)}")
print(f"    ---")
print(f"    Backend Packages          : {len(stack['packages_backend'])}")
print(f"    Frontend Packages         : {len(stack['packages_frontend'])}")
print(f"    Third-Party Services      : {len(stack['third_party_services'])}")
