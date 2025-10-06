from pathlib import Path
path = Path("resources/views/hypothesis/create.blade.php")
text = path.read_text(encoding="utf-8")
marker = "            if (saveHypothesisBtn) {\r\n"
block = (
    "            const openPaymentModal = () => {\r\n"
    "                if (!paymentModalInstance) {\r\n"
    "                    handleCreateHypothesis();\r\n"
    "                    return;\r\n"
    "                }\r\n\r\n"
    "                if (paymentModalLoader) {\r\n"
    "                    paymentModalLoader.classList.remove('d-none');\r\n"
    "                }\r\n    "
)
