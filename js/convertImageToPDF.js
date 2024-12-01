async function convertToPDF() {
    const { jsPDF } = window.jspdf;

    const fileInput = document.getElementById('file-upload');
    if (fileInput.files.length === 0) {
        alert("Please upload a file.");
        return;
    }

    const file = fileInput.files[0];

    const reader = new FileReader();
    reader.onload = async function (event) {
        const pdf = new jsPDF();

        if (file.type.startsWith('image/')) {
            // Handle image files (e.g., JPEG, PNG)
            const img = new Image();
            img.src = event.target.result;
            img.onload = function () {
                const imgWidth = pdf.internal.pageSize.getWidth();
                const imgHeight = (img.height / img.width) * imgWidth; // Maintain aspect ratio
                pdf.addImage(img, 'JPEG', 0, 0, imgWidth, imgHeight);
                pdf.save('converted-file.pdf');
            };
        } else if (file.type === 'application/pdf') {
            // If it's already a PDF, just save it
            const pdfBlob = new Blob([event.target.result], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(pdfBlob);
            link.download = 'converted-file.pdf';
            link.click();
        } else {
            alert("Unsupported file type. Only images and PDFs are supported.");
        }
    };

    if (file.type.startsWith('text/')) {
        reader.readAsText(file); // Read text files
    } else {
        reader.readAsDataURL(file); // Read images and others as base64
    }
}
