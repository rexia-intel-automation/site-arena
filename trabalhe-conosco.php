<?php /** Trabalhe Conosco - Arena BRB */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trabalhe Conosco - Faça parte da equipe Arena BRB Mané Garrincha">
    <title>Trabalhe Conosco - Arena BRB Mané Garrincha</title>
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
        <h1 class="page-title">Trabalhe Conosco</h1>
        <p class="page-subtitle">Faça parte da equipe que realiza os maiores eventos do Brasil</p>
    </section>

    <div class="form-container">
        <div class="info-box">
            <h4>Por que trabalhar na Arena BRB?</h4>
            <p>A Arena BRB Mané Garrincha é mais do que um local de eventos – somos um complexo multiuso que proporciona experiências inesquecíveis para milhões de pessoas. Nossa equipe é formada por profissionais apaixonados, dedicados e que buscam excelência em tudo o que fazem.</p>
            <p><strong>Oferecemos:</strong></p>
            <ul style="color: var(--color-text-secondary); margin: 10px 0 0 20px;">
                <li>Ambiente dinâmico e desafiador</li>
                <li>Oportunidades de crescimento profissional</li>
                <li>Benefícios competitivos</li>
                <li>Cultura de diversidade e inclusão</li>
                <li>Experiência em eventos de classe mundial</li>
            </ul>
        </div>

        <!-- Vagas Abertas -->
        <div style="text-align: center; margin: 40px 0; padding: 40px; background: var(--color-card-bg); border-radius: 16px; border: 1px solid var(--color-border);">
            <h2 style="margin-bottom: 16px;">Vagas Abertas</h2>
            <p style="color: var(--color-text-secondary); margin-bottom: 30px;">
                Confira nossas oportunidades em aberto e candidate-se através da plataforma Sólides
            </p>
            <a href="https://arenabrb.solides.jobs/" target="_blank" class="btn-outline-primary" style="max-width: 400px; margin: 0 auto;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                Ver Vagas no Sólides
            </a>
        </div>

        <!-- Formulário de Cadastro -->
        <div class="form-card">
            <h2 style="margin-top: 0; margin-bottom: 12px; color: var(--color-text-primary);">Cadastro para Banco de Talentos</h2>
            <p style="color: var(--color-text-secondary); margin-bottom: 30px;">
                Não encontrou a vaga ideal? Cadastre seu currículo em nosso banco de talentos e seja considerado para futuras oportunidades.
            </p>

            <form id="careersForm" method="POST" action="#" enctype="multipart/form-data" onsubmit="handleCareersFormSubmit(event)">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nome" class="form-label required">Nome Completo</label>
                        <input type="text" id="nome" name="nome" class="form-input" required placeholder="Seu nome completo">
                    </div>

                    <div class="form-group">
                        <label for="cpf" class="form-label required">CPF</label>
                        <input type="text" id="cpf" name="cpf" class="form-input" required placeholder="000.000.000-00" maxlength="14">
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

                <div class="form-row">
                    <div class="form-group">
                        <label for="data_nascimento" class="form-label required">Data de Nascimento</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="cidade" class="form-label required">Cidade/Estado</label>
                        <input type="text" id="cidade" name="cidade" class="form-input" required placeholder="Brasília - DF">
                    </div>
                </div>

                <div class="form-group">
                    <label for="area_interesse" class="form-label required">Área de Interesse</label>
                    <select id="area_interesse" name="area_interesse" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="administracao">Administração</option>
                        <option value="operacoes">Operações e Eventos</option>
                        <option value="marketing">Marketing e Comunicação</option>
                        <option value="comercial">Comercial e Vendas</option>
                        <option value="financeiro">Financeiro</option>
                        <option value="rh">Recursos Humanos</option>
                        <option value="ti">Tecnologia da Informação</option>
                        <option value="manutencao">Manutenção e Facilities</option>
                        <option value="seguranca">Segurança</option>
                        <option value="atendimento">Atendimento ao Cliente</option>
                        <option value="juridico">Jurídico</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cargo_interesse" class="form-label required">Cargo de Interesse</label>
                    <input type="text" id="cargo_interesse" name="cargo_interesse" class="form-input" required placeholder="Ex: Analista de Marketing">
                </div>

                <div class="form-group">
                    <label for="escolaridade" class="form-label required">Escolaridade</label>
                    <select id="escolaridade" name="escolaridade" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="fundamental">Ensino Fundamental</option>
                        <option value="medio">Ensino Médio</option>
                        <option value="tecnico">Técnico</option>
                        <option value="superior_cursando">Superior Cursando</option>
                        <option value="superior_completo">Superior Completo</option>
                        <option value="pos_cursando">Pós-Graduação Cursando</option>
                        <option value="pos_completo">Pós-Graduação Completo</option>
                        <option value="mestrado">Mestrado</option>
                        <option value="doutorado">Doutorado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="formacao" class="form-label">Formação/Curso</label>
                    <input type="text" id="formacao" name="formacao" class="form-input" placeholder="Ex: Administração de Empresas">
                </div>

                <div class="form-group">
                    <label for="experiencia" class="form-label required">Experiência Profissional (resumo)</label>
                    <textarea id="experiencia" name="experiencia" class="form-textarea" required placeholder="Descreva brevemente sua experiência profissional, principais cargos e empresas..."></textarea>
                </div>

                <div class="form-group">
                    <label for="linkedin" class="form-label">LinkedIn</label>
                    <input type="url" id="linkedin" name="linkedin" class="form-input" placeholder="https://www.linkedin.com/in/seu-perfil">
                </div>

                <div class="form-group">
                    <label for="curriculo" class="form-label required">Currículo (PDF ou DOC)</label>
                    <input type="file" id="curriculo" name="curriculo" class="form-input" required accept=".pdf,.doc,.docx">
                    <div class="form-hint">Tamanho máximo: 5MB</div>
                </div>

                <div class="form-group">
                    <label for="observacoes" class="form-label">Informações Adicionais</label>
                    <textarea id="observacoes" name="observacoes" class="form-textarea" placeholder="Conte-nos mais sobre você, suas habilidades especiais, certificações, idiomas, etc."></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="aceite_lgpd" required style="margin-top: 4px;">
                        <span style="font-size: 0.9rem; color: var(--color-text-secondary);">
                            Declaro que li e concordo com a <a href="politica-privacidade" target="_blank" style="color: var(--color-primary); font-weight: 600;">Política de Privacidade</a> e autorizo o tratamento de meus dados pessoais conforme a LGPD para fins de processos seletivos.
                        </span>
                    </label>
                </div>

                <input type="hidden" name="solides_api_url" value="https://api.solides.com.br/arenabrb/candidatos">

                <button type="submit" class="form-submit">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                        <path d="M22 2L11 13"/>
                        <path d="M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                    Enviar Currículo
                </button>
            </form>
        </div>

        <div class="form-divider">
            <span>OU</span>
        </div>

        <!-- Link Direto Sólides -->
        <div class="form-card" style="text-align: center;">
            <h3 style="margin-top: 0; color: var(--color-text-primary);">Envie pelo Sistema Sólides</h3>
            <p style="color: var(--color-text-secondary); margin-bottom: 24px;">
                Prefere cadastrar seu currículo diretamente na plataforma Sólides? Clique no botão abaixo.
            </p>
            <a href="https://arenabrb.solides.jobs/cadastro" target="_blank" class="btn-outline-primary" style="max-width: 400px; margin: 0 auto;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    <polyline points="15 3 21 3 21 9"/>
                    <line x1="10" y1="14" x2="21" y2="3"/>
                </svg>
                Acessar Plataforma Sólides
            </a>
        </div>

        <!-- Informações sobre Processo Seletivo -->
        <div class="info-box" style="margin-top: 40px;">
            <h4>Como funciona nosso processo seletivo?</h4>
            <ol style="color: var(--color-text-secondary); margin: 10px 0 0 20px;">
                <li style="margin-bottom: 10px;"><strong>Cadastro:</strong> Envie seu currículo pelo formulário acima ou pela plataforma Sólides</li>
                <li style="margin-bottom: 10px;"><strong>Triagem:</strong> Nossa equipe de RH analisará seu perfil</li>
                <li style="margin-bottom: 10px;"><strong>Entrevista:</strong> Candidatos selecionados serão convidados para entrevista</li>
                <li style="margin-bottom: 10px;"><strong>Avaliação:</strong> Testes técnicos e/ou comportamentais (conforme a vaga)</li>
                <li style="margin-bottom: 10px;"><strong>Proposta:</strong> Candidato aprovado receberá proposta formal</li>
            </ol>
            <p style="margin-top: 16px;"><strong>Prazo:</strong> O processo seletivo dura em média de 2 a 4 semanas, podendo variar conforme a vaga.</p>
        </div>

        <!-- Contato RH -->
        <div class="contact-info" style="margin-top: 30px;">
            <h3>Dúvidas sobre Vagas?</h3>
            <p><strong>Departamento de Recursos Humanos</strong></p>
            <a href="mailto:rh@arenabrb.com.br">rh@arenabrb.com.br</a>
            <p style="margin-top: 12px; font-size: 0.9rem; color: var(--color-text-secondary);">
                Respondemos em até 48 horas úteis
            </p>
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
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }
            e.target.value = value;
        });

        function handleCareersFormSubmit(event) {
            event.preventDefault();

            // Validar tamanho do arquivo
            const fileInput = document.getElementById('curriculo');
            const file = fileInput.files[0];

            if (file && file.size > 5 * 1024 * 1024) { // 5MB
                alert('O arquivo do currículo excede o tamanho máximo de 5MB. Por favor, escolha um arquivo menor.');
                return;
            }

            // TODO: Implementar envio real do formulário para API Sólides
            const formData = new FormData(event.target);

            console.log('Dados do formulário:');
            for (let [key, value] of formData.entries()) {
                if (key !== 'curriculo') {
                    console.log(key + ': ' + value);
                }
            }

            alert('Seu currículo foi enviado com sucesso!\n\nObrigado por seu interesse em fazer parte da equipe Arena BRB.\n\nEntraremos em contato em breve caso seu perfil esteja alinhado com nossas oportunidades.');

            // Limpar formulário
            event.target.reset();
        }
    </script>
</body>
</html>
