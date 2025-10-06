from pathlib import Path
path = Path("resources/views/profile/index.blade.php")
text = path.read_text(encoding="utf-8")
text = text.replace("        .profile-sidebar .list-group-item {\n            border-radius: 0 !important;\n            padding: 0.85rem 1.25rem;\n            font-size: 1.05rem;\n        }", "        .profile-sidebar .list-group-item {\n            border-radius: 0 !important;\n            padding: 1rem 1.35rem;\n            font-size: 1.075rem;\n        }")
text = text.replace("            border-left: 3px solid transparent;", "            border-left: 4px solid transparent;")
text = text.replace("            border-left-color: var(--bs-primary);", "            border-left-color: #e2241b;")
text = text.replace("            border: none;", "            border: none;\n            border-radius: 0;")
path.write_text(text, encoding="utf-8")
