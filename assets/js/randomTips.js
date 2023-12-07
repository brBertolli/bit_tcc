// Array com as dicas
var dicas = [
    "Na página de login, caso você já tenha uma sessão ativa, sempre aparecerá um atalho para o sistema!",
    "Por motivos de segurança, sempre encerre sua sessão de usuário.",
    "Nunca forneça sua senha a nenhuma outra pessoa.",
    "Se estiver com dificuldades para utilizar a plataforma, peça ajuda à algum Administrador..",
    "Atualize o registro de serviços realizados, mantendo um histórico completo de cada reparo.",
    "Automatize a geração de faturas e recibos após a conclusão de um serviço.",
    "Desenvolva relatórios abrangentes que exibam o desempenho da equipe, análise de vendas e métricas de atendimento.",
    "Implemente hierarquias de acesso para funcionários, garantindo a segurança de informações sensíveis.",
    "Priorize a segurança dos dados dos clientes e da empresa com as medidas de proteção avançadas.",
    "Registre o tempo dedicado a cada reparo, permitindo a análise da eficiência operacional da equipe.",
    "Utilize o sistema para gerenciar contratos de serviços.",
    "Analise a rentabilidade de diferentes serviços e clientes por meio de relatórios detalhados.",
    "Crie uma base de conhecimento interna com soluções para problemas técnicos comuns.",
    "Registre todas as atividades executadas no sistema para fins de auditoria e transparência."
];


// Função para gerar um número aleatório entre 0 e o tamanho das dicas
function gerarNumeroAleatorio() {
    return Math.floor(Math.random() * dicas.length);
}

// Loop para atribuir dicas aleatórias aos elementos HTML
for (var i = 0; i < 5; i++) {
    if (dicas.length === 0) {
        break; // Todas as dicas foram usadas, saia do loop
    }

    var indiceAleatorio = gerarNumeroAleatorio();
    var dicaAtual = dicas.splice(indiceAleatorio, 1)[0]; // Remove a dica usada
    var elementoDica = document.getElementById("dica-0" + (i + 1));
    elementoDica.textContent = dicaAtual;
}
