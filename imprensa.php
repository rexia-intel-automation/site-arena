<?php /** Fale com a Imprensa - Arena BRB */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Assessoria de Imprensa - Arena BRB Mané Garrincha">
    <title>Fale com a Imprensa - Arena BRB Mané Garrincha</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/legal-pages.css">
    <link rel="stylesheet" href="assets/css/pages/forms.css">
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <button class="theme-toggle-floating" onclick="toggleTheme()" aria-label="Alternar tema">
        <svg id="sun-icon" class="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2m-8.93-8.93 1.41 1.41m12.73 0 1.41-1.41M2 12h2m16 0h2m-14.07 5.07-1.41 1.41m12.73 0-1.41-1.41"/>
        </svg>
        <svg id="moon-icon" class="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
        </svg>
    </button>

    <nav id="navbar">
        <ul class="nav-links nav-links-left">
            <li><a href="/">Início</a></li>
            <li><a href="eventos">Eventos</a></li>
            <li><a href="espacos">Espaços</a></li>
        </ul>
        <a href="/" class="logo">
            <img src="https://i.imgur.com/51FYi3K.png" alt="Arena BRB" class="logo-img logo-dark">
            <img src="https://i.imgur.com/qAvyaL0.png" alt="Arena BRB" class="logo-img logo-light">
        </a>
        <ul class="nav-links nav-links-right">
            <li><a href="noticias">Notícias</a></li>
            <li><a href="tour">Tour</a></li>
            <li><a href="contato">Contato</a></li>
        </ul>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <section class="page-header">
        <h1 class="page-title">Fale com a Imprensa</h1>
        <p class="page-subtitle">Assessoria de imprensa e comunicação da Arena BRB</p>
    </section>

    <div class="form-container">
        <div class="info-box">
            <h4>Informações para Jornalistas e Veículos de Comunicação</h4>
            <p>Nossa assessoria de imprensa está à disposição para fornecer informações, agendar entrevistas, organizar visitas técnicas e disponibilizar materiais de mídia sobre a Arena BRB Mané Garrincha.</p>
            <p><strong>Horário de atendimento:</strong> Segunda a sexta, das 9h às 18h</p>
            <p><strong>Prazo de resposta:</strong> Até 24 horas úteis</p>
        </div>

        <div class="contact-methods">
            <div class="contact-method-card">
                <div class="contact-method-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <path d="m22 6-10 7L2 6"/>
                    </svg>
                </div>
                <h4>E-mail Direto</h4>
                <p>Para solicitações urgentes</p>
                <a href="mailto:imprensa@arenabrb.com.br">imprensa@arenabrb.com.br</a>
            </div>

            <div class="contact-method-card">
                <div class="contact-method-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <h4>Telefone</h4>
                <p>Atendimento direto</p>
                <a href="tel:+556133334444">(61) 3333-4444</a>
            </div>

            <div class="contact-method-card">
                <div class="contact-method-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                </div>
                <h4>WhatsApp</h4>
                <p>Mensagens rápidas</p>
                <a href="https://wa.me/556133334444" target="_blank">(61) 3333-4444</a>
            </div>
        </div>

        <div class="form-card">
            <h2 style="margin-top: 0; margin-bottom: 24px; color: var(--color-text-primary);">Envie sua Solicitação</h2>

            <form id="pressForm" method="POST" action="#" onsubmit="handlePressFormSubmit(event)">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome" class="form-label required">Nome Completo</label>
                        <input type="text" id="nome" name="nome" class="form-input" required placeholder="Seu nome">
                    </div>

                    <div class="form-group">
                        <label for="veiculo" class="form-label required">Veículo/Empresa</label>
                        <input type="text" id="veiculo" name="veiculo" class="form-input" required placeholder="Nome do veículo">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label required">E-mail</label>
                        <input type="email" id="email" name="email" class="form-input" required placeholder="seu@email.com">
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="form-label required">Telefone/WhatsApp</label>
                        <input type="tel" id="telefone" name="telefone" class="form-input" required placeholder="(61) 99999-9999">
                    </div>
                </div>

                <div class="form-group">
                    <label for="tipo_solicitacao" class="form-label required">Tipo de Solicitação</label>
                    <select id="tipo_solicitacao" name="tipo_solicitacao" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="entrevista">Solicitação de Entrevista</option>
                        <option value="informacoes">Pedido de Informações</option>
                        <option value="credenciamento">Credenciamento para Evento</option>
                        <option value="visita">Visita Técnica/Tour</option>
                        <option value="material">Solicitação de Material/Imagens</option>
                        <option value="nota">Direito de Resposta/Nota Oficial</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="assunto" class="form-label required">Assunto</label>
                    <input type="text" id="assunto" name="assunto" class="form-input" required placeholder="Resumo da solicitação">
                </div>

                <div class="form-group">
                    <label for="mensagem" class="form-label required">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" class="form-textarea" required placeholder="Descreva sua solicitação com o máximo de detalhes possível..."></textarea>
                    <div class="form-hint">Inclua informações como prazo, formato desejado, contexto da matéria, etc.</div>
                </div>

                <div class="form-group">
                    <label for="prazo" class="form-label">Prazo para Resposta</label>
                    <select id="prazo" name="prazo" class="form-select">
                        <option value="">Selecione...</option>
                        <option value="urgente">Urgente (hoje)</option>
                        <option value="24h">24 horas</option>
                        <option value="48h">48 horas</option>
                        <option value="semana">Até 1 semana</option>
                        <option value="normal">Sem urgência</option>
                    </select>
                </div>

                <input type="hidden" name="recipient_email" value="imprensa@arenabrb.com.br">

                <button type="submit" class="form-submit">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                        <path d="M22 2L11 13"/>
                        <path d="M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                    Enviar Solicitação
                </button>
            </form>
        </div>

        <div class="form-divider">
            <span>OU</span>
        </div>

        <div class="form-card" style="text-align: center;">
            <h3 style="margin-top: 0; color: var(--color-text-primary);">Converse com nosso Assistente Virtual</h3>
            <p style="color: var(--color-text-secondary); margin-bottom: 24px;">
                Obtenha respostas rápidas sobre eventos, histórico da Arena BRB, informações técnicas e muito mais através de nossa base de conhecimento.
            </p>
            <button onclick="openVirtualAssistant()" class="btn-outline-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Falar com Assistente Virtual
            </button>
        </div>

        <div class="info-box" style="margin-top: 40px;">
            <h4>Materiais Disponíveis para Download</h4>
            <p>Acesse nossa página de <a href="midia-kit" style="color: var(--color-primary); font-weight: 600;">Mídia Kit</a> para fazer download de:</p>
            <ul style="color: var(--color-text-secondary); margin: 10px 0 0 20px;">
                <li>Logotipos em alta resolução</li>
                <li>Fotos oficiais da Arena BRB</li>
                <li>Releases e notas oficiais</li>
                <li>Informações técnicas do complexo</li>
                <li>Manual de marca</li>
            </ul>
        </div>
    </div>

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logos">
                    <img src="https://i.imgur.com/xqyCXoQ.png" alt="Arena BSB" class="footer-logo footer-logo-dark">
                    <img src="https://i.imgur.com/O0Vv0Y2.png" alt="Arena BSB" class="footer-logo footer-logo-light">
                    <img src="https://i.imgur.com/sfPqjWD.png" alt="BRB Banco" class="footer-logo footer-logo-dark">
                    <img src="https://i.imgur.com/OM1Bshn.png" alt="BRB Banco" class="footer-logo footer-logo-light">
                </div>
                <p>Complexo multiuso no coração de Brasília, preparado para receber os maiores eventos do país.</p>
            </div>
            <div class="footer-col"><h4>Arena</h4><ul><li><a href="eventos">Agenda</a></li><li><a href="espacos">Espaços</a></li><li><a href="tour">Tour Virtual</a></li></ul></div>
            <div class="footer-col"><h4>Operação</h4><ul><li><a href="contato">Contato Comercial</a></li><li><a href="regulamento-acesso">Regulamento de Acesso</a></li><li><a href="codigo-conduta">Código de Conduta</a></li></ul></div>
            <div class="footer-col"><h4>Legal</h4><ul><li><a href="termos-uso">Termos de Uso</a></li><li><a href="politica-privacidade">Política de Privacidade</a></li><li><a href="politica-cookies">Política de Cookies</a></li></ul></div>
        </div>
        <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Arena BRB. Todos os direitos reservados.</p></div>
    </footer>

    <script src="assets/js/main.js"></script>
    <script>
        function handlePressFormSubmit(event) {
            event.preventDefault();

            // TODO: Implementar envio real do formulário
            // Por enquanto, apenas exibe mensagem de sucesso

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());

            console.log('Dados do formulário:', data);

            alert('Sua solicitação foi enviada com sucesso!\n\nNossa equipe de imprensa entrará em contato em breve.\n\nE-mail de destino: ' + data.recipient_email);

            // Limpar formulário
            event.target.reset();
        }

        function openVirtualAssistant() {
            // TODO: Implementar integração com assistente virtual
            alert('Assistente Virtual em desenvolvimento!\n\nEm breve você poderá conversar com nosso assistente e obter informações instantâneas sobre a Arena BRB.');
        }
    </script>
</body>
</html>
